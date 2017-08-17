<?php
include('db.php');	

include("admin_header.php")
?>
<div id="wrapcontent" >
<div class="movielist"> 
<?php 
$movielist=mysqli_query($conn,"SELECT *
				FROM movie ORDER BY movieCode DESC") 
				or die(mysqli_error($conn));

				while($movie = mysqli_fetch_assoc($movielist)){
				$movies[]=$movie;

				}?>
	
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
<tr><td><a class="btn" href="editmovie.php?movieCode='.$movie["movieCode"].'">Edit</a>&nbsp;&nbsp;<!--<button class="btn">Add to front page</button><button class="btn">In Theater</button></td>--></tr>



</table></div>'
;}?>
</div>


<div class="artistlist">
<div class="container_div">
<h1 class="container_div_h1">Recently Added Artists</h1>

<?php $artistlist=mysqli_query($conn,"SELECT artistId,firstName,lastName,dob,dod,nationality,image,Biography
				FROM artist ORDER BY artistId DESC") 
				or die(mysqli_error($conn));

while($artistarray = mysqli_fetch_array($artistlist, MYSQLI_ASSOC)){
		
		$results1=mysqli_query($conn,"(SELECT m.title, a.moviecode FROM roles a, movie m WHERE a.artistid='$artistarray[artistId]' AND a.moviecode = m.moviecode LIMIT 3)")or die(mysqli_error($conn));
	  	
		echo'<div class="artistwidget" style="width: 480px; float: left;">
				<table style="border-spacing: 5px 0px; padding:10px;">
					<tr><td rowspan="5"><img STYLE ="width:200px; height:270px;" src="'. $artistarray['image'].'"/></td></tr>
					<tr><td><a href="artist_detail.php?artistId='.$artistarray['artistId'].'"><span style="font-size:20px;">'.$artistarray['firstName']." ".$artistarray['lastName'].'</span></a></br>'.$artistarray['dob'].' - ';
						if(empty($artistarray['dod'])){
						echo $artistarray['dod'];
						}
						echo '</td></tr>';


			
				
		
			echo'<tr><td>'.substr($artistarray['Biography'],0,210).'</td></tr>
				<tr><td><h2>Known for:</h2>'; while($movies=mysqli_fetch_array($results1)){
				echo '<a href="movie_detail.php?movieCode='.$movies['moviecode'].'">'.$movies['title'].',</a>&nbsp';}
				echo '</td></tr>
				<tr><td><a class="btn" href="editartist.php?artistId='.http_build_query(array(artist=>$artistarray)).'">Edit</a></td></tr>
				</table></div>'; 
				
						
				}
		
				
				?>
					
		
		</div></div>
	
</div>
</div>


</div>
</body>

</html>
