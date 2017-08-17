<?php include ("header.php");
include ("session.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); ?>

<link href="css/screen.css" rel="stylesheet" type="text/css" media="screen" />	
<script type="text/javascript" src="js/easySlider1.7.js"></script>
<script type="text/javascript" src="js/html5lightbox/html5lightbox.js"></script>
<script type="text/javascript">
		
		$(document).ready(function(){
				jQuery("#slider").easySlider({
				auto: false, 
				continuous: false,
				numeric:true,
				hoverpause: true,
				
			});
		});	
	</script>

<?php 
	  include ("db.php");
	  $movieresult=mysqli_query($conn,"(SELECT * FROM movie ORDER BY movieCode DESC LIMIT 8)")or die(mysqli_error($conn));
	  while($movie=mysqli_fetch_array($movieresult)){
	 	$movies[]=$movie;
		}
		
echo '<div id="wrapcontent" >
	
	<div id="content" style="float:left;">
	<div class="sectionhead"><p id="section_h1"> RECENT MOVIES </p></div>
		<div style="width:600px;height:475px;overflow:hidden;margin-right:20px; border-radius:10px;box-shadow: 5px 5px 5px #888888;" id="slider" >
			<ul>';
foreach($movies as $movie){
		$row1=mysqli_query($conn,"SELECT firstname, lastname, artistId FROM  artist WHERE artistId=(SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and 
		role = 'Director')")or die(mysqli_error($conn));
		
		$row2= mysqli_query($conn,"SELECT firstname, lastname, artistId FROM  artist WHERE artistId=(SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and 
		role = 'Writer') ")or die(mysqli_error($conn));
		
		$row3=mysqli_query($conn,"SELECT firstname, lastname, artistId FROM  artist WHERE artistId IN (SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and 
		role LIKE '%lead%')")or die(mysqli_error($conn));
		
		$directerrow =mysqli_fetch_assoc($row1);
		$director=$directerrow ["firstname"].' '.$directerrow ["lastname"];
		
		$writrrow =mysqli_fetch_assoc($row2);
		$writer=$writrrow["firstname"].' '.$writrrow["lastname"];
		
		while($actor=mysqli_fetch_array($row3)){
	 	$actors[]=$actor;
		} 			
		echo  
	'<li><section class="section_top" style="width:745px;" >
	<div style =" width:310px;">
			<img id ="img_top_section"src="'.$movie["image"].'" />
	</div>
	<div style ="width:400px; ">
		<a href="movie_detail.php?movieCode='.$movie["movieCode"].'"><h1>'.$movie["title"].' </h1></a>
		<h2>Release date: '.$movie["releaseDate"].'</h2>
		<div><img src ="3-5star.png" style ="width= 600px; height:50px;margin-top:5px;"/></div>
			<div style ="width:400px;min-height:205px;">
			<P>'.substr($movie["plot"],0,550).'..
			<a href="movie_detail.php?movieCode='.$movie["movieCode"].'/#plot" class="read_more">Read More</a><br/></p>
			</div>
			<div>
			<table style="margin-top:-5px;">
				<tr>
				<th>Director:</th>
				<td style="padding:0 0"><a href="artist_detail.php?artistId='.$directerrow ["artistId"].'" >'.$director.' </a></td>
				</tr>
			</table>
			<table>
				<tr>
				<th>Writer:</th>
				<td style="padding:0 0"><a href="artist_detail.php?artistId='.$writrrow["artistId"].'" >'.$writer.'</a></td>
				</tr>
			</table>
			<table>
				<tr>
				<th>Stars:</th>
				<td style="padding:0 0">';
				foreach($actors as $actor){
				echo '<a href="artist_detail.php?artistId='.$actor["artistId"].'" >'.$actor["firstname"].' '.$actor["lastname"].'</a> &nbsp';
				}
				$actors= null;
				echo'<a href="movie_detail.php?movieCode='.$movie["movieCode"].'/#stars" > See all</a>
				</td>
				</tr>
			</table>
			
			
		</div>
	
	
	<div class="section_top" style ="width:400px;">
		<div style="width:300px;" >
			<div style="overflow:hidden; margin-top:10px;">
			<a href="movie_detail.php?movieCode='.$movie["movieCode"].'" class="btn">VIEW DETAIL INFO</a>
			<a href="http://www.youtube.com/embed/YE7VzlLtp-4" class="html5lightbox" title="Big Buck Bunny Copyright Blender Foundation">
			<input type="button" class="btn" value="WATCH TRAILER"></a>
			<!--<input type="button" class="btn" onclick="location.href();" value="Share it">-->
			</div>
		
			<!--<div style="clear:both;"><img src ="ostar.png" style ="width= 300px; height:20px; margin-right:5px; margin-top:10px; vertical-align:bottom;"/><span style="vertical-align:middle; display:inline-block; margin-left:10px;font: normal normal 14px Arial, Tahoma, Helvetica, FreeSans, sans-serif;color:#666; ">Rate it</span></div>
		</div>
		<div style =" float:left;"><img src ="'.$_SESSION['login_profilepic'].'" style ="width=65px; height:65px;"/></div>
		<div>
		<form id="userreviewinput">
			<TEXTAREA style="border-radius: 3px; border: 1px solid #ccc; font:-webkit-small-control; font-size: 13px; background:#ddd;" NAME="review" ROWS=3 COLS=57 id="review"> Post your reviews and comments here ...</TEXTAREA>	
			<input type="button" class="btn" onclick="location.href();" value="Post your review">
		</form>
		</div>-->
		
	</div>
	
	
</section>
</li>';} ?>
				
			</ul>
		</div>
		
	</div>
	
	<div id="trailers">
	<div class="sectionhead" style="overflow:hidden;clear:both;"><p id="section_h1" style="margin: 2px 3px 2px;border-top-left-radius:10px;font-weight:bold;width: initial;">RECENT TRAILERS</p></div>
	<div  style="overflow-y: scroll;height: 460px;width: 245px;padding: 6px; overflow-x: hidden;">
	
			<a href="http://www.youtube.com/embed/YE7VzlLtp-4" class="html5lightbox" title="Moviename"><img style="width:230px; height:120px; margin:2px 4px 0px 4px;" src="<?php echo getThumbnail("http://www.youtube.com/embed/YE7VzlLtp-4");?>"></a>

			<img style="width:230px; height:120px; margin:8px 4px 0px 4px;" src="http://img.youtube.com/vi/4EvNxWhskf8/hqdefault.jpg" title="YouTube Video" alt="YouTube Video" />
			<img style="width:230px; height:120px; margin:8px 4px 0px 4px;"src="http://img.youtube.com/vi/4EvNxWhskf8/hqdefault.jpg" title="YouTube Video" alt="YouTube Video" />
			<img style="width:230px; height:120px; margin:8px 4px 0px 4px;"src="http://img.youtube.com/vi/4EvNxWhskf8/hqdefault.jpg" title="YouTube Video" alt="YouTube Video" />
			<img style="width:230px; height:120px; margin:8px 4px 0px 4px;"src="http://img.youtube.com/vi/4EvNxWhskf8/hqdefault.jpg" title="YouTube Video" alt="YouTube Video" />
			<img style="width:230px; height:120px; margin:8px 4px 0px 4px;"src="http://img.youtube.com/vi/4EvNxWhskf8/hqdefault.jpg" title="YouTube Video" alt="YouTube Video" />
					


			</div>
			</div>
			<div class="container_div" style="float:right;width:800px;margin-top:2px;margin-left:1px;">
			<p class="container_div_h1">POPULAR MOVIES</p>
			<div style="margin-left:10px;margin-bottom-15px;">
				<?php if(!isset($_GET['sortby'])||($_GET['sortby'])=="all"){
					$poprow=mysqli_query($conn,"select image,title,movieCode,rating from movie ORDER BY rating DESC LIMIT 12");
					}
					elseif(($_GET['sortby'])!="all"){
					$poprow=mysqli_query($conn,"(SELECT image,title,movieCode FROM movie WHERE genre like '%$_GET[sortby]%' ORDER BY rating DESC LIMIT 12 )");
						}
						while($popmovie=mysqli_fetch_assoc($poprow)){
						$popmovies[]=$popmovie;
						}
						
			foreach($popmovies as $popmovie){
			echo '<div class="index_pop_movie"><a href="movie_detail.php?movieCode='.$popmovie["movieCode"].'">
				<div class="index_pop_movie_rating"><img src ="ostar.png" style ="width= 300px; height:25px; margin-right:5px; margin-top:10px; vertical-align:bottom;"/> </div>
				<img style="width:190px; height:270px;" src="'.$popmovie["image"].'">'.$popmovie["title"].'
			<a href=""></div>';}
			?>
			
			
			
			</div>
			</div>
			<div style="float:left;">
			<div class="container_div" style="width:193px;margin-top:2px;margin-left:10px;">
			<p class="container_div_h1"style="margin:auto;padding:auto;">GENRE</p>
			<ul>
						<li><a href="index.php?sortby=all">All</a></li>
						<li><a href="index.php?sortby=action">Action</a></li>
						<li><a href="index.php?sortby=adventure">Adventure</a></li>
						<li><a href="index.php?sortby=comedy">Comedy</a></li>
						<li><a href="index.php?sortby=drama">Drama</a></li>
						<li><a href="index.php?sortby=romance">Romance</a></li>
						<li><a href="index.php?sortby=thriller">Thriller</a></li>
						
			<ul>
			
			
			</div>
			<div class="container_div" style="width:193px;margin-top:2px;margin-left:10px;">
			<p class="container_div_h1" style="margin:auto;padding:auto;">COMING SOON</p>
				<ul>
						<li><a href="">Movie name 1</a></li>
						<li><a href="">Movie name 2</a></li>
						<li><a href="">Movie name 4</a></li>
						<li><a href="">Movie name 3</a></li>
						<li><a href="">Movie name 5</a></li>
						<li><a href="">Movie name 6</a></li>
						
			<ul>
			
			</div>
			<div class="container_div" style="width:193px;margin-top:2px;margin-left:10px;">
			<p class="container_div_h1" style="margin:auto;padding:auto;">IN THEATERS</p>
				<ul>
					<?php 
					
					 $theatermovieresult=mysqli_query($conn,"(SELECT title,movieCode FROM movie WHERE inTheater=1 LIMIT 8)")or die(mysqli_error($conn));
					  while($theatermovie=mysqli_fetch_array($theatermovieresult)){
						echo'<li><a href="movie_detail.php?movieCode='.$theatermovie['movieCode'].'">'.$theatermovie['title'].'</a></li>';
						}
					?>
			<ul>
			
			</div>
			</div>
			
			
			
			
			
			
			<?php function getThumbnail($youtubelink){


				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubelink, $match)) {
				$video_id = $match[1];
				$thumbnaillink="http://img.youtube.com/vi/".$video_id."/1.jpg";
				return $thumbnaillink;
				}
				
			}
			?>
			
	
	
</div>
	


</body>

	
</html>