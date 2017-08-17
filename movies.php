<?php include('header.php');
include('db.php');

if((!isset($_GET['sort']))&&(!isset($_GET['sortby']))){
$row=mysqli_query($conn,"select * from movie");
}elseif(isset($_GET['sortby'])){
$row=mysqli_query($conn,"(SELECT * FROM movie WHERE genre like '%$_GET[sortby]%' ORDER BY a) Union (SELECT * FROM movie) ");
}elseif((isset($_GET['sort']))&&(!isset($_GET['sortbygenre']))){
$row=mysqli_query($conn,"select * from movie ORDER BY $_GET[sort]");		
}
while($movie=mysqli_fetch_assoc($row)){
$movies[]=$movie;
}

?>




<div id="wrapcontent" >
<div class="container_div" style="position:static;">

<a style="margin-left:20px;" >SORT BY</a>
<a style="margin-left:150px;"href="movies.php?sort=title">Name</a>
<a style="margin-left:20px;" href="movies.php?sort=releasedate">Release Year</a>
<a style="margin-left:20px;"href="movies.php?sort=rating">Rating</a>
<a style="margin-left:20px;" id="genre" href="">Genre</a> 
<div id="genrelist"><ul ><li><a href="movies.php?sortby=action">Action</a></li>
						<li><a href="movies.php?sortby=adventure">Adventure</a></li>
						<li><a href="movies.php?sortby=comedy">Comedy</a></li>
						<li><a href="movies.php?sortby=drama">Drama</a></li>
						<li><a href="movies.php?sortby=romance">Romance</a></li>
						<li><a href="movies.php?sortby=thriller">Thriller</a></li>

</div>

</div>
<div class="container_div">
<?php foreach($movies as $movie){
$row1=mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname, artistId FROM  artist WHERE artistId=(SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and role ='Director')")or die(mysqli_error($conn));

$director =mysqli_fetch_assoc($row1);

$row3=mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname, artistId FROM  artist WHERE artistId IN (SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and role LIKE '%lead%')")or die(mysqli_error($conn));

while($actor=mysqli_fetch_array($row3)){
$actors[]=$actor;
		}
$genres = explode(',', $movie['genre']);
		
echo '<div class="moviewidget"><table style="border-spacing: 5px 0px; paddying:10px;">
<tr><td rowspan="5"><img STYLE ="width:200px; height:270px;"src="'.$movie['image'].'"/></tr>
<tr><td ><span style="font-size:20px;"><a href="movie_detail.php?movieCode='.$movie["movieCode"].'" >'.$movie['title'].'</a></span></br>'.$movie['releaseDate']."&nbsp;&nbsp;&nbsp;&nbsp;";
 foreach($genres as $key){
 echo '<span style="color:lightslategray;">'.$key.'   </span>';
 }
echo '</td></tr>
	<tr><td>
	<img style="width:100px;height:20px;"src="ostar.png"/></td></tr>
	<tr><td>'.
	substr($movie["plot"],0,210).'..</br>
	Director: <a href="artist_detail.php?artistId='.$director["artistId"].'" >'.$director["fullname"].'</a></br>
	Stars: ';foreach($actors as $actor){
				echo '<a href="artist_detail.php?artistId='.$actor["artistId"].'" >'.$actor["fullname"].'</a> &nbsp';
				}
				$actors= null;
				echo '</div>
	</td></tr>
<tr><td><button class="btn" >Watchtrailer</button><input type="hidden" id="moviecode" value="'.$movie["movieCode"].'"/>';
	if (in_array($movie["movieCode"],$_SESSION['fav_movie'])){
	echo '<input type="button" class="btn" id="fav" style="background-color:green;" value="REMOVE FROM WATCHLIST">';
	}else{
	echo '<input type="button" class="btn" id="fav" value="ADD TO WATCHLIST">';
	} echo'</td></tr>

</table></div>'
;}?>
</div>
</div>


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
