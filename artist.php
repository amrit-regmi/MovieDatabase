<?php 
		session_start();
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		include ("header.php");
	  include ("db.php");
	  $artistlist=mysqli_query($conn,"SELECT artistId,CONCAT(firstname,' ',lastname) AS fullname,dob,dod,nationality,image,Biography
				FROM artist ORDER BY artistId DESC") 
				or die(mysqli_error($conn));

?>

<div id="wrapcontent" >
<div class="container_div">
<h1 class="container_div_h1">Recently Added Artists</h1>

<?php 

while($artistarray = mysqli_fetch_array($artistlist, MYSQLI_ASSOC)){
		
		$results1=mysqli_query($conn,"(SELECT m.title, a.moviecode FROM roles a, movie m WHERE a.artistid='$artistarray[artistId]' AND a.moviecode = m.moviecode LIMIT 3)")or die(mysqli_error($conn));
	  	
		echo'<div class="artistwidget" style="width: 600px; float: left;">
				<table style="border-spacing: 5px 0px; padding:10px;">
					<tr><td rowspan="5"><img STYLE ="width:100px; height:150px;" src="'. $artistarray['image'].'"/></td></tr>
					<tr><td><a href="artist_detail.php?artistId='.$artistarray['artistId'].'"><span style="font-size:20px;">'.$artistarray['fullname'].'</span></a></br>'.$artistarray['dob'].' - ';
						if(empty($artistarray['dod'])){
						echo $artistarray['dod'];
						}
						echo '</td></tr>';
			echo'<tr><td>'.substr($artistarray['Biography'],0,260).'..</td></tr>
				<tr><td><span style="font-weight:bold">Known for: </span>'; while($movies=mysqli_fetch_array($results1)){
				echo '<a href="movie_detail.php?movieCode='.$movies['moviecode'].'">'.$movies['title'].',</a>&nbsp';}
				echo '</table></div>'; 
				
						
				}
		
				
				?>
					
		
		</div>
		</div>