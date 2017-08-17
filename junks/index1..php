<?php include ("header.php");
	  include ("db.php");
	  $movieresult=mysqli_query($conn,"(SELECT * FROM movie ORDER BY movieCode DESC LIMIT 8)")or die(mysqli_error($conn));
	  while($movie=mysqli_fetch_array($movieresult)){
	 	$movies[]=$movie;
		}
		
echo '<div id="wrapcontent" >
<h1> RECENT MOVIES </h1>';


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
		
echo '<section class="section_top" >
	<div style =" width:310px;">
			<img id ="img_top_section"src="'.$movie["image"].'" />
	</div>
	<div style ="width:670px;">
		<h1>'.$movie["title"].' </h1>
		<h2>Release date: '.$movie["releaseDate"].'</h2>
			<P>'.$movie["plot"].'
			<a href="movie_detail.php?movieCode='.$movie["movieCode"].'" class="read_more">Read More</a><br/></p>
			<table style="margin-top:-15px;">
				<tr>
				<th>Director:</th>
				<td><a href="artist_detail.php?artistId='.$directerrow ["artistId"].'" >'.$director.' </a></td>
				</tr>
			</table>
			<table>
				<tr>
				<th>Writer:</th>
				<td><a href="artist_detail.php?artistId='.$writrrow["artistId"].'" >'.$writer.'</a></td>
				</tr>
			</table>
			<table>
				<tr>
				<th>Stars:</th>
				<td>';
				foreach($actors as $actor){
				echo '<a href="artist_detail.php?artistId='.$actor["artistId"].'" >'.$actor["firstname"].' '.$actor["lastname"].'</a> &nbsp';
				}
				$actors= null;
				echo'
				</td>
				</tr>
			</table>
			<table>
				<tr><td><a href="movie_detail.php?movieCode='.$movie["movieCode"].'" > See all</a></td></tr>
			</table>
		</div>
	<div><img src ="3-5star.png" style ="width= 600px; height:40px;"/></div>
	
	<div class="section_top" style ="width:670px;">
		<div style="width:300px;" >
			<div style="overflow:hidden;">
			<input type="button" class="search_submit" onclick="location.href();" value="Queue it">
			<input type="button" class="search_submit" onclick="location.href();" value="Watch it online">
			<input type="button" class="search_submit" onclick="location.href();" value="Share it">
			</div>
		
			<div><img src ="ostar.png" style ="width= 300px; height:25px; margin-right:5px; vertical-align:middle;"/><span style="vertical-align:middle;">Rate it</span></div>
		</div>
		<div style =" float:right;"><img src ="profile.jpeg" style ="width=200px; height:65px;"/></div>
		<div>
		<form id="userreviewinput">
			<TEXTAREA NAME=review ROWS=3 COLS=93> Post your reviews and comments here ...</TEXTAREA>	
			<input type="button" class="search_submit" onclick="location.href();" value="Post your review">
		</form>
		</div>
		
	</div>
	
</section>';
}
?>
<h1>  GOSSIPS </h1>
<div>
<article class="gossips_article">
		<div id="leftdiv">
		<img id="img_article_gossips" src="celeb1.jpg"/>
		</div>
		<div id="rightdiv"">
		<h1>Red Panda shiefted to UK</h1>
		<p>The Panda has become the symbol of WWF. The well-known panda 
			logo of WWF originated from a panda named Chi Chi that was transferred
			from the Beijing Zoo to the London Zoo in the same year of the establishment of of WWF
			<a href="#" class="read_more">Read More</a><br/></p>
		</div>
</article>
<article class="gossips_article">
		<div id="leftdiv">
		<img id="img_article_gossips" src="celeb2.jpg"/>
		</div>
		<div id="rightdiv"">
		<h1>Red Panda shiefted to UK</h1>
		<p>The Panda has become the symbol of WWF. The well-known panda 
			logo of WWF originated from a panda named Chi Chi that was transferred
			from the Beijing Zoo to the London Zoo in the same year of the establishment of of WWF
			<a href="#" class="read_more">Read More</a><br/></p>
		</div>
</article>
<article class="gossips_article">
		<div id="leftdiv">
		<img id="img_article_gossips" src="celeb3.jpg"/>
		</div>
		<div id="rightdiv"">
		<h1>Red Panda shiefted to UK</h1>
		<p>The Panda has become the symbol of WWF. The well-known panda 
			logo of WWF originated from a panda named Chi Chi that was transferred
			from the Beijing Zoo to the London Zoo in the same year of the establishment of of WWF
			<a href="#" class="read_more">Read More</a><br/></p>
		</div>
</article>
<article class="gossips_article">
		<div id="leftdiv">
		<img id="img_article_gossips" src="celeb4.jpg"/>
		</div>
		<div id="rightdiv"">
		<h1>Red Panda shiefted to UK</h1>
		<p>The Panda has become the symbol of WWF. The well-known panda 
			logo of WWF originated from a panda named Chi Chi that was transferred
			from the Beijing Zoo to the London Zoo in the same year of the establishment of of WWF
			<a href="#" class="read_more">Read More</a><br/></p>
		</div>
</article>
</div>

</div>
href="



</body>
</html>
