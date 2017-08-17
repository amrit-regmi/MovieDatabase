<?php include ('header.php');
	include('db.php');
	$keyword=$_POST['search'];
	$narrowSearch=$_POST['searchby'];
	$search_behave=$_POST['searchbehave'];
	
	$results_movie=NULL;
	$resuts_artists=NULL;
	  //while($movie=mysqli_fetch_array($movieresult)){
	 	//$movies[]=$movie;
		//}
		
		function search($rows,$db_table,$matching_row,$search_keyword){
			global $conn;
			$search_result=mysqli_query($conn,"(SELECT $rows FROM $db_table WHERE $matching_row LIKE '%$search_keyword%')")or die(mysqli_error($conn));
			
			while($result=mysqli_fetch_assoc($search_result)){
			$results[]=$result;
			}
			return $results;
			}
		
		function search_display_artist($artistarray){
			global $conn;
			$movieresult=mysqli_query($conn,"(SELECT a.movieCode,m.title FROM roles a, movie m WHERE a.moviecode = m.moviecode AND a.artistid='$artistarray[artistId]' LIMIT 3)")or die(mysqli_error($conn));
				while($relatedmovie=mysqli_fetch_assoc($movieresult)){
					$relatedmovies[]=$relatedmovie;
					}
				
			echo '<div style="clear:both;">
					
					<div style="float:left;"><img class="search_img" style="width:70px; height:70px; display:inline-block; margin:10px;"src="'.$artistarray['image'].'"/>
					</div>
					
					<div style="float:left; margin:10px;"><a href="artist_detail.php?artistId='.$artistarray["artistId"].'" >'.$artistarray["fullname"].'</a>
						<div><p style="display:inline;">From movie:';
						foreach($relatedmovies as $relatedmovie){
						echo '<a href="movie_detail.php?movieCode='.$relatedmovie["movieCode"].'" >'.$relatedmovie["title"].'</a> &nbsp;&nbsp'; } echo '</p>
						</div>
					</div>
				</div>';
		}
		function search_display_movie($moviearray){
			global $conn;
			$artistresult=mysqli_query($conn,"SELECT CONCAT(firstName,' ',lastName) AS fullname, artistId FROM  artist WHERE artistId IN (SELECT artistId FROM roles WHERE movieCode ='$moviearray[movieCode]' and 
		role LIKE '%lead%')")or die(mysqli_error($conn));
			while($relatedartist=mysqli_fetch_assoc($artistresult)){
					$relatedartists[]=$relatedartist;
					}
		
		
		echo '<div style="clear:both;">
				<div style="float:left;">
				<img class="search_img" style="width:70px; height:70px; display:inline-block; margin:10px;"src="'.$moviearray['image'].'"/>
				</div>
					
				<div style="float:left; margin:10px;">
				<a href="movie_detail.php?artistId='.$moviearray["movieCode"].'" >'.$moviearray["title"].
				'</a>
					<div><p style="display:inline;">Release Date: '.$moviearray["releaseDate"].'</p></div>
					
					
					<div><p style="display:inline;">Artists: ';
					foreach($relatedartists as $relatedartist){
						echo '<a href="artist_detail.php?artistId='.$relatedartist["artistId"].'" >'.$relatedartist["fullname"].'</a> &nbsp;&nbsp'; }
						echo '...</p>
					</div>
				</div>
				
				
			</div>';
		
		
		
		}
		if ($narrowSearch=="All"){
			$results_movies=search('title,movieCode,image,releaseDate','movie','title',$keyword);
			$results_artists=search("artistId,CONCAT(firstName,' ',lastName) AS fullname ,image","artist","CONCAT(firstName,' ',lastName)",$keyword);
		}elseif($narrowSearch=="Movies"){
			$results_movies=search('title,movieCode,image,releaseDate','movie','title',$keyword);
		}elseif($narrowSearch=="Artists"){
			$results_artists=search("artistId,CONCAT(firstName,' ',lastName) AS fullname ,image","artist","CONCAT(firstName,' ',lastName)",$keyword);
		}
		
		?>
	<div id="wrapcontent" ><div class="container_div">
	
	
	
	
	<p class="container_div_p" style="font-size:23px;padding-top:0px;padding-bottom:0px;margin-bottom:0px;">Results for <span style="color:green;"><?php echo $keyword;?></span>  searched in  <?php echo $narrowSearch.'</p></ class="container_div">'; 
	
		if(empty($results_movies)&&empty($results_artists)){
		echo '<p class="container_div_p">No RESULTS FOUND</p>';}

		if(!empty($results_movies)){
			echo '<div style="clear:both;"><p class="container_div_h1">MOVIES</p>';
				foreach($results_movies as $movie){
				search_display_movie($movie);
				}
			echo '</div>';
		}
		if(!empty($results_artists)){
			echo '<div style="clear:both;">
			<p class="container_div_h1">ARTISTS</p>';
			foreach($results_artists as $artist){
				search_display_artist($artist);
				
			}
			//echo 'this is'.$_SESSION['currentpage'];
			echo '</div>';
			}
		
			
			
			
			?>
	</div>
	</div>
