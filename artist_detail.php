<?php session_start();
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		include('db.php');
		if(isset($_SESSION['login_username'])&&$_SESSION['usertype']=="0") {
		include ("admin_header.php");
		}
		else{
		include ("header.php");
		}
	  
	  
	  $artistId = $_GET["artistId"];
	  $results=mysqli_query($conn,"(SELECT * FROM artist  WHERE artistId='$artistId')")or die(mysqli_error($conn));
	  $artist=mysqli_fetch_assoc($results);
	  
	  $results1=mysqli_query($conn,"(SELECT a.*,m.title FROM roles a, movie m WHERE a.moviecode = m.moviecode AND a.artistid='$artistId')")or die(mysqli_error($conn));
	  while($movierole=mysqli_fetch_array($results1)){
	  		$movieroles[]=$movierole;
	  	 }
	  ?>
		
<div id="wrapcontent" >
<div class="container_div">
<?php if(isset($_SESSION['login_username'])&&$_SESSION['usertype']=="0"){?>	
		<form  method="POST"  action="process.php"   onsubmit="return confirm('Are you sure you want to delete this artist,this will remove all the records of this artist from releted movies as well, Once deleted it cant be undone');" >
		<input type="hidden" name="delete_artistCode" value="<?php echo $artistId;?>"/>
		<input type="submit" style="position:absolute; left:770px;"class="btn" value ="DELETE ARTIST" />
		</form>
		<a style="position:absolute; left: 890px;" class="btn" href="editartist.php?<?php echo http_build_query(array(artist=>$artist))?>">EDIT DETAILS</a>
		
<?php  } ?>

<section class="section_top" >
	<div style =" width:310px;">
			<img id ="img_top_section"src="<?php echo$artist["image"];?>" />
	</div>
	<div style ="width:650px;">
		<h1><?php echo $artist["firstName"].'&nbsp'.$artist["lastName"];?> </h1>
		<h2><?php echo $artist["dob"].'&nbsp-&nbsp';
		if(empty($artist[dod])){echo $artist["dod"];}?> 
		</h2>
			<p>'<?php echo $artist["Biography"];?>
			<a href="#biography" class="read_more">Read More</a><br/></p>
			
		</div>
	
</section>
</div>
<div class="container_div">
<p class="container_div_h1">APPEARED IN</p>
<section class="table">
<table style="width:75%">
<tr>
<th>Appeared Movies</th>
<th>Role</th>
<th>Movie Character</th></tr>
<?php foreach($movieroles as $movierole){
echo'<tr ><td id="centre"><a href="movie_detail.php?movieCode='.$movierole["movieCode"].'">'.$movierole["title"].'</a></td><td>'.$movierole["role"].'</td><td>'.$movierole["movieCharacter"].'</td></tr>';
}?>
</table>
</section>
</div>
<a name="biography" id="biography"></a>
<div class="container_div">
<p class="container_div_h1">BIOGRAPHY</p>
<p class="container_div_p"><?php echo $artist["Biography"];?>

</div>
</div>

</body>
</html>

