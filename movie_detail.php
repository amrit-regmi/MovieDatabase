<?php 
		session_start();
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		if(isset($_SESSION['login_username'])&&$_SESSION['usertype']=="0") {
		include ("admin_header.php");
		}
		else{
		include ("header.php");
		}
	  include ("db.php");
	$movieId = $_GET["movieCode"];
	
		//getting releted movie
	  $movieresult=mysqli_query($conn,"(SELECT * FROM movie where movieCode= '$movieId')")or die(mysqli_error($conn));
	  $movie=mysqli_fetch_assoc($movieresult);
	  
	  //getting comments and releted users
	  $row1=mysqli_query($conn,"SELECT * FROM comment where moviecode= '$movieId' ORDER BY commentid DESC LIMIT 8")or die(mysqli_error($conn));
		while($comment=mysqli_fetch_assoc($row1)){	
		$row2=mysqli_query($conn,"SELECT CONCAT(firstName,' ',lastName) AS fullname, profilepic FROM user where userId= $comment[userId]") or die(mysqli_error($conn));
		$commentor=mysqli_fetch_assoc($row2);
		$comment['commentor']=$commentor;
		$comments[]=$comment;
		}
		
		
		
		
		//getting all the artists
	  	$row=mysqli_query($conn,"SELECT a.artistid,CONCAT(m.firstname,' ', m.lastname) AS fullname, a.role ,a.movieCharacter  FROM roles a, artist m WHERE a.moviecode = '$movie[movieCode]' AND a.artistid= m.artistid") or die(mysqli_error($conn));
		
		while($artist=mysqli_fetch_array($row)){
		$artists[]=$artist;
		if(strpos($artist["role"],'ead')!== FALSE){ //getting lead actors name and id
			$actors[]=$artist;
		}
		if(strpos($artist["role"],'irector')!== FALSE){//filtering director
			$director=$artist["fullname"];
			$directorid=$artist["artistid"];
			
		}
		if(strpos($artist["role"],'riter')!== FALSE){//filtering writer
			$writer=$artist["fullname"];
			$writerid=$artist["artistid"];
		}

		}
		?>
		
<div id="wrapcontent" >
		
		
	
<div class="container_div">
<?php if(isset($_SESSION['login_username'])&&$_SESSION['usertype']=="0"){?>	
		<form  method="POST"  action="process.php"   onsubmit="return confirm('Are you sure you want to delete this movie, Once deleted it cant be undone');" >
		<input type="hidden" name="delete_movieCode" value="<?php echo $movieId; ?>"/>
		<input type="submit" style="position:absolute; left:770px;"class="btn" value ="DELETE MOVIE" />
		</form>
		<a style="position:absolute; left: 890px;" class="btn" href="editmovie.php?movieCode=<?php echo $movieId?>">EDIT DETAILS</a>
		
<?php  } ?>
<section class="section_top" >
	<div style =" width:310px;">
			<img id ="img_top_section"src="<?php echo $movie["image"];?>" />
	</div>
	<div style ="width:645px;">
		<h1><?php echo $movie["title"];?> </h1>
		<h2>Release date: <?php echo $movie["releaseDate"];?></h2>
			<P><?php echo substr($movie["plot"],0,300);?>
			<a href="#plot">..Read More</a><br/></p>
			<table style="margin-top:-15px;">
				<tr>
				<th>Director:</th>
				<td><a href="artist_detail.php?artistId=<?php echo $directorid.'" >'.$director;?> </a></td>
				</tr>
			</table>
			<table>
				<tr>
				<th>Writer:</th>
				<td><a href="artist_detail.php?artistId=<?php echo $writerid.'" >'.$writer;?></a></td>
				</tr>
			</table>
			<table>
				<tr>
				<th>Stars:</th>
				<td>
				<?php foreach($actors as $actor){
				echo '<a href="artist_detail.php?artistId='.$actor["artistid"].'" >'.$actor["fullname"].'</a> &nbsp';
				}?>
				</td>
				</tr>
			</table>
			<table>
				<tr><td><a href="#stars" > See all</a></td></tr>
			</table>
		</div>
	<div><img src ="3-5star.png" style ="width= 600px; height:40px;"/></div>
	
	<div class="section_top" style ="width:660px;">
		<div style="width:300px;" >
			<div style="overflow:hidden;">
			<button class="btn" >Watchtrailer</button><input type="hidden" id="moviecode" value="<?php echo $movie["movieCode"]; ?>"/>
			<?php if (in_array($movie["movieCode"],$_SESSION['fav_movie'])){
				echo '<input type="button" class="btn" id="fav" style="background-color:green;" value="REMOVE FROM WATCHLIST">';
				}else{
				echo '<input type="button" class="btn" id="fav" value="ADD TO WATCHLIST">';
				}?>
			</div>
		
			<div><img src ="ostar.png" style ="width= 300px; height:25px; margin-right:5px; vertical-align:middle;"/><span style="vertical-align:middle;">Rate it</span></div>
		</div>
		<div style =" float:right;"><img src ="<?php echo $_SESSION['login_profilepic']?>" style ="width=200px; height:65px;"/></div>
		<div>
		<form id="userreviewinput" action="process.php" method="post" >
			<textarea required="required" id="review" name="review" rows="3" cols="90" 
				<?php if(isset($_SESSION['login_username'])){echo 'placeholder = "Post your reviews and comments here.."';}else
				{ 
				echo 'placeholder="please login to post comment" disabled';
				}
				?>"></textarea>	
			<input id="moviecode" type="hidden" name="cmt_moviecode" value="<?php echo $movie["movieCode"];?>" />
			<input type="submit" class="cmt_btn" style="float:right;" value="Post your review" <?php if(!isset($_SESSION['login_username'])){echo ' disabled';}?>/>
		</form>
		</div>
		
	</div>
	
</section>
</div>
<div class="container_div">
<a name="stars"></a>
<p class="container_div_h1">Artists</p>
<section class="table">
<table style="width:75%">
<tr>
<th>Artist Name</th>
<th>Role</th>
<th>Movie Character</th></tr>
<?php foreach($artists as $artist){
echo'<tr ><td id="centre"><a href="artist_detail.php?artistId='.$artist["artistid"].'">'.$artist["fullname"].'</a></td><td>'.$artist["role"].'</td><td>'.$artist["movieCharacter"].'</td></tr>';
}?>
</table>
</section>
</div>
<div class="container_div">
<a name="plot"></a>
<p class="container_div_h1">PLOT</p>
<p class="container_div_p"><?php echo $movie["plot"];?></p>
</div>
<div class="container_div">
<p class="container_div_h1">USER REVIEWS</p>

<form style="padding:20px 20px; width:950px; overflow:auto;"id="userreviewinput" action="process.php" method="post" >
			
			<div style="float:left;">
				<img src="<?php echo $_SESSION['login_profilepic'];?>" style="width:100px; height:89px; "/>
			</div>
			<div style="float:left; width:800px; margin-left:10px;">
				<textarea required="required" id="review" name="review" rows="5" cols="118" 
				<?php if(isset($_SESSION['login_username'])){echo 'placeholder = "Post your reviews and comments here.."';}else
				{ 
				echo 'placeholder="please login to post comment" disabled';
				}
				?>"></textarea>
			</div>
			<input id="moviecode" type="hidden" name="cmt_moviecode" value=" <?php echo $movieId;?> " />
			<input type="submit" class="cmt_btn" style="float:right;" value="Post your review" <?php if(!isset($_SESSION['login_username'])){echo ' disabled';}?>/>
</form>
<a name="comment_section"></a>
			<?php foreach($comments as $comment){ ?> 
			<div class="comment_div" style="margin-bottom: 20px;padding-left:20px; position: relative;clear: both; overflow:auto;">
				<div style="float:left;">
				<img src="<?php echo $comment['commentor']['profilepic'];?>" style="width:100px; height:100px;"/>
				</div>
				<div style="float:left; width:800px;">
				<p class="container_div_p"style="padding-top:0px; margin-top:0px;">
				<span style="font-weight: bold;color: cadetblue;font-size: larger;">	<?php echo $comment['commentor']['fullname'].'</span></br>'.$comment['comment']; ?>
				</p>
				</div>
			</div>
			<?php }?>
</div>
<?php if(isset($_SESSION['login_username'])){
		$login=true;
}else{
$login=false;
}?>

<script>
$(document).delegate('#fav','click',function() 
{
var login=<?php echo $login ?>;
var clicked=this
if (login==true){
var command=$(clicked).val();
var movieCode=$(clicked).prev("#moviecode").val();
var dataString ='&fav_movieCode='+movieCode+'&favourite='+command;
$.ajax({
type: "POST",
url:"process.php",
data: dataString,
cache: false,
success: function(html){
if ($(clicked).val()=="ADD TO WATCHLIST"){
		$(clicked).val("REMOVE FROM WATCHLIST");
		$(clicked).css('background','green');
	}else{	
	$(clicked).val("ADD TO WATCHLIST");
	$(clicked).css('background','#3299BB');
	
	}

console.log(dataString);
}
});
return false;
}
else{
alert("please login first to add to watchlist");
}
}); 
</script>


