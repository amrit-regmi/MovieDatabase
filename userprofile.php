<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include('session.php');
		include('db.php');
		if(isset($_SESSION['login_username'])&&$_SESSION['usertype']=="0") {
		include ("admin_header.php");
		}
		else{
		include ("header.php");
		};
if (!isset($_SESSION['login_username'])){
exit;

}
?>
<div id="wrapcontent" >
<div class="movielist"> 
<?php 

$user=$_SESSION['login_username'];
$fav_movie=$_SESSION['fav_movie'];
foreach($fav_movie as $moviecode){
	$movielist=mysqli_query($conn,"SELECT * FROM movie Where movieCode='$moviecode'") or die(mysqli_error($conn));
			while($movie = mysqli_fetch_assoc($movielist)){
				$movies[]=$movie;}

}
?>
	
<div class="container_div">
<h1 class="container_div_h1">Recently Added Movies</h1>
<?php foreach($movies as $movie){
$row1=mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname, artistId FROM  artist WHERE artistId=(SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and role ='Director')")or die(mysqli_error($conn));

$director =mysqli_fetch_assoc($row1);

$row3=mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname, artistId FROM  artist WHERE artistId IN (SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and role LIKE '%lead%')")or die(mysqli_error($conn));

while($actor=mysqli_fetch_array($row3)){
$actors[]=$actor;
		}
$genres = explode(',', $movie['genre']);
		
echo '<div class="moviewidget" style="width:480px;float:left;"><table style="border-spacing: 5px 0px; padding:10px;">
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
	<span style="font-weight:bold;">Director:</span> <a href="artist_detail.php?artistId='.$director["artistId"].'" >'.$director["fullname"].'</a></br>
	<span style="font-weight:bold;">Stars:</span> ';foreach($actors as $actor){
				echo '<a href="artist_detail.php?artistId='.$actor["artistId"].'" >'.$actor["fullname"].'</a> &nbsp';
				}
				$actors= null;
				echo '</div>
	</td></tr>
<tr><td><input type="hidden" id="moviecode" value="'.$movie["movieCode"].'"/><input type="button" class="btn" id="fav" style="background-color:green;" value="REMOVE FROM WATCHLIST"><!--<button class="btn">Add to front page</button><button class="btn">In Theater</button></td>--></tr>



</table></div>'
;}?>

<script>
$(document).delegate('#fav','click',function() 
{
//var login=<?php echo $login ?>;
var clicked=this
//if (login==true){
var command=$(clicked).val();
var movieCode=$(clicked).prev("#moviecode").val();
var dataString ='&fav_movieCode='+movieCode+'&favourite='+command;
$.ajax({
type: "POST",
url:"process.php",
data: dataString,
cache: false,
success: function(html){
$(clicked).parents('.moviewidget').remove();

console.log(dataString);
}
});
return false;
//}
//else{
//alert("please login first to add to watchlist");
//}
}); 
//
</script>




</div>