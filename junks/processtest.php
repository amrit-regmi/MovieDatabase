<?php
	include('db.php');
	session_start();
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

	// MOVIE PART
	if(isset($_POST)==true && empty($_POST)==false && isset($_POST['moviename'])){
	$title=$_POST['moviename'];
	$releasedate=$_POST['releasedate'];
	$genre=$_POST['genre'];
	$intheater=$_POST['intheater'];
	$plot=mysql_real_escape_string($_POST['plot']);
	//$rating=$_POST['rating'];
	$all_query_ok=true;
	mysqli_autocommit($conn, FALSE);
	
	
	//IF USER IS EDITING EXISTING MOVIE
	if(isset($_POST['edit'])){	
	$moviecode=$_POST['edit'];
	//checking if user is updating duplicate value 	
	$fetch=mysqli_query($conn,"select title,movieCode from movie WHERE title='$title'")? null : $all_query_ok=false;
	$check=mysqli_fetch_assoc($fetch);
	$num_rows=mysqli_num_rows($fetch);
		if($check['movieCode']!=$moviecode&&$num_rows>0){
		$_SESSION['duplicate_msg']="The title ".$title." you entered already exists, Please enter the new title";
		header('Location:' . $_SERVER['HTTP_REFERER']); 	
			exit();
			}
			//if no-duplicate value update information
			else{
			mysqli_query($conn,"UPDATE movie SET title='$title', releaseDate='$releasedate',genre='$genre',plot='$plot',inTheater='$intheater'
			WHERE movieCode='$moviecode'")? null : $all_query_ok=false;
				//if the user changed the profile picture as well
				if (isset($_FILES['movieimg'])&& ($_FILES['movieimg']['size'][0]) > 0){
					print_r ($_FILES['movieimg']['size']);
					$uploadlocation_movieimg= uploadmyimage("movieimg","0","moviepics",$title);
					mysqli_query($conn,"UPDATE movie SET image='$uploadlocation_movieimg' WHERE movieCode='$moviecode'")? null : $all_query_ok=false; 
					}
				//removing the movie from roles table
				mysqli_query($conn,"DELETE FROM roles WHERE movieCode='$moviecode'")or die(mysqli_error($conn))? null : $all_query_ok=false;
			}
	}
	
	//ADDING THE MOVIE 
	elseif(!isset($_POST['delete_movieCode']) && !isset($_POST['edit']) ){ 
	$fetch=mysqli_query($conn,"select title,movieCode from movie WHERE title='$title'")? null : $all_query_ok=false;
	$check=mysqli_fetch_assoc($fetch);
	
	//checking if such movie already exists
	if($check['movieCode']!=$moviecode){
		$_SESSION['duplicate_msg']="The title ".$title." you entered already exists, Please enter the new title";
		header('Location:' . $_SERVER['HTTP_REFERER']); 
		exit();//exit with error if duplicate value
	}
	$uploadlocation_movieimg= uploadmyimage("movieimg","0","moviepics",$title);
	mysqli_query($conn,"INSERT INTO movie (title,releaseDate,genre,image,plot,rating,inTheater) VALUES ('$title', '$releasedate','$genre','$uploadlocation_movieimg','$plot','$rating','$intheater')")or die(mysqli_error($conn))? null : $all_query_ok=false;
	$moviecode = mysqli_insert_id($conn);
	}
	
	//ASSIGNING THE ARTIST TO MOVIE
	if(isset($_POST['fullname'])){
	$fullname=$_POST['fullname'];
	$role=$_POST['role'];
	$character=$_POST['character'];
	$existingartist_length = count($fullname);//getting total number of artist in the movie
	for($i=0; $i < $existingartist_length; $i++){//adding each artist to role table
		$result=mysqli_query($conn,"SELECT artistId FROM artist WHERE CONCAT(firstName,' ',lastName)='$fullname[$i]'")or die(mysqli_error($conn))? null : $all_query_ok=false;//getting artist id for aritist from artst table
		$row =mysqli_fetch_assoc($result);
			if($row!="")
			{
			$artistId= $row["artistId"];
			mysqli_query($conn,"INSERT INTO roles (movieCode,artistId,role,movieCharacter) VALUES ('$moviecode','$artistId','$role[$i]','$character[$i]')")or die(mysqli_error($conn))? null : $all_query_ok=false;//inserting artistid and movieid to roles
			}
		}
	}
	
	//IF USER ADDED THE NEW ARTIST THAT DO NOT EXIST WHILE ADDING THE MOVIE
	if(isset($_POST['newartistfn'])){

	$newartistfn=$_POST['newartistfn'];
	$newartistln=$_POST['newartistln'];
	$newartistdob=$_POST['newartistdob'];
	$newartistdod=$_POST['newartistdod'];
	$newartistnat=$_POST['newartistnat'];
	$newartistbio=$_POST['newartistbio'];
	$newartistrole=$_POST['newartistrole'];
	$newartistchar=$_POST['newartistchar'];

		$newartist_length = count($newartistfn);//getting the number of new artists
		for($i=0; $i< $newartist_length; $i++)//adding each artist to artist table
		{
		$uploadlocation_movieimg= uploadmyimage("newartistimg","$i","moviepics",$newartistfn[$i].$newartistln[$i]); //uploading image 
		
		mysqli_query($conn,"INSERT INTO artist (firstName,lastName,dob,dod,nationality,Biography,image) VALUES ('$newartistfn[$i]', '$newartistln[$i]','$newartistdob[$i]','$newartistdod[$i]','$newartistnat[$i]','".mysql_real_escape_string($newartistbio[$i])."','$uploadlocation_movieimg')")or die(mysqli_error($conn))? null : $all_query_ok=false; //inserting artist
		$artistId=mysqli_insert_id($conn); //getting the last inserted artist
		mysqli_query($conn,"INSERT INTO roles (movieCode,artistId,role,movieCharacter) VALUES ('$moviecode','$artistId','$newartistrole[$i]','$newartistchar[$i]')")or die(mysqli_error($conn))? null : $all_query_ok=false;//inserting artist into roles
		echo mysqli_error($conn);
		}
	}
	else{
	echo "error";
		}
		
	if($all_query_ok){//checking if all the queries were executed without error
			mysqli_commit($conn); //commiting the connection
			mysqli_autocommit($conn, TRUE);
			header('Location:movie_detail.php?movieCode='.$moviecode);	
			exit();	
		
		}
	else{
			mysqli_rollback($conn);
			echo mysqli_error($conn);
			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit();
		}
	
	}
	
	
	
	
	
	
	//ARTIST PART
		
		//ADDING NEW ARTIST 
	elseif(isset($_POST)==true && empty($_POST)==false && isset($_POST['fname'])){
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$dob=$_POST['dob'];
		$dod=$_POST['dod'];
		$nationality=$_POST['nationality'];
		$biography= mysqli_real_escape_string($_POST['biography']);
		$all_query_ok=true;
		mysqli_autocommit($conn, FALSE);
		
	/*$fetch=mysqli_query($conn,"select artistId from artist WHERE firstname='$fname' AND lastName = '$lname' ")?null : $all_query_ok=false;
	$check=mysqli_fetch_assoc($fetch);
	$num_rows=mysqli_num_rows($fetch);
	if($num_rows==1){
	$_SESSION['duplicate_msg']="The artist name ".$fname." ".$lname." you entered already exists, Please enter the new title";
	header('Location:' . $_SERVER['HTTP_REFERER']); 
	exit();
	}*/
	
	//IF USER IS EDITING EXISTING ARTIST
	if(isset($_POST['edit'])){	
	$edit_artistId=$_POST['edit'];
			mysqli_query($conn,"UPDATE artist SET firstName='$fname', lastName='$lname',dob='$dob',dod='$dod',nationality='$nationality',image='$image',Biography='$biography' WHERE artistId='$edit_artistId'")? null : $all_query_ok=false; //updating the artist
				
				if (isset($_FILES['movieimg'])&& ($_FILES['movieimg']['size'][0]) > 0){//if user changed the profile picture then update
					$uploadlocation_artistimg= uploadmyimage("file","0","artistpics",$fname.$lname);
					mysqli_query($conn,"UPDATE artist SET image='$uploadlocation_artistimg' WHERE artistId='$edit_artistId'")? null : $all_query_ok=false; 
					}
					//removing record from roles
				mysqli_query($conn,"DELETE FROM roles WHERE artistId='$edit_artistId'")or die(mysqli_error($conn))? null : $all_query_ok=false;
				
				if($all_query_ok){//if everything okey update and exit
					mysqli_commit($conn);
					mysqli_autocommit($conn, TRUE);
					header('Location:artist_detail.php?artistId='.$edit_artistId);
					exit();
				}
					else{
					mysqli_rollback($conn);
					header('Location:' . $_SERVER['HTTP_REFERER']);
					exit();
					}
			}
			
		//ADDING NEW ARTIST
		elseif(isset($_POST) && !isset($_POST['edit']) ){ 
		
		$uploadlocation= uploadmyimage("file","0","artistpics",$fname.$lname);

		mysqli_query($conn,"INSERT INTO artist (firstName,lastName,dob,dod,nationality,image,Biography) VALUES ('$fname', '$lname','$dob','$dod','$nationality','$uploadlocation','$biography')")or die(mysqli_error($conn))? null : $all_query_ok=false;
		$artistId = mysqli_insert_id($conn);
		
		if($all_query_ok){ //checking if all the queries executed without error
			mysqli_commit($conn);
			mysqli_autocommit($conn, TRUE);
			header('Location:artist_detail.php?artistId='.$artistId);
				
			
		}else{
			mysqli_rollback($conn);
			echo "error";
			header('Location:'.$_SERVER['HTTP_REFERER']);
			}
		}
		}
		
	//FOR THE USER REVIEW OF MOVIE
	if(isset($_POST['review'])){
		$review=mysql_real_escape_string($_POST['review']);
		$userid=$_SESSION['login_username'];
		$cmt_moviecode = $_POST['cmt_moviecode'];
		mysqli_query($conn,"INSERT INTO comment(comment,moviecode,userId) VALUES ('$review','$cmt_moviecode','$userid')")or die(mysqli_error($conn));
		header('Location:movie_detail.php?movieCode='.$cmt_moviecode.'/#comment_section');
		exit();

	}
	//IF THE USER WANTED TO DELETE THE MOVIE
	if(isset($_POST['delete_movieCode'])){
		$all_query_ok=true;
		mysqli_autocommit($conn, FALSE);
		$moviecode=$_POST['delete_movieCode'];
		mysqli_query($conn,"DELETE FROM roles WHERE movieCode='$moviecode'")or die(mysqli_error($conn))? null : $all_query_ok=false; //Unassigning from roles table
		mysqli_query($conn,"DELETE FROM movie WHERE movieCode='$moviecode'")or die(mysqli_error($conn))? null : $all_query_ok=false;//removing record from movie table
		
		if($all_query_ok){
			mysqli_commit($conn);
			mysqli_autocommit($conn, TRUE);
			header('Location:PROFILE.php');
		
			}else{
			echo "error deletaing";
		
			}
	}
	//IF THE USER WANTED TO DELETE THE ARTIST
	if(isset($_POST['delete_artistCode'])){
		$all_query_ok=true;
		mysqli_autocommit($conn, FALSE);
		$delete_artistcode=$_POST['delete_artistCode'];
		mysqli_query($conn,"DELETE FROM roles WHERE artistId='$delete_artistcode'")or die(mysqli_error($conn))? null : $all_query_ok=false;//unassigning from roles
		mysqli_query($conn,"DELETE FROM artist WHERE artistId='$delete_artistcode'")or die(mysqli_error($conn))? null : $all_query_ok=false;
		//deleting from artist
		
		
		if($all_query_ok){
			mysqli_commit($conn);
			mysqli_autocommit($conn, TRUE);
			header('Location:PROFILE.php');
			exit();
			}else{
			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit();
			}
	}
	
	
	







function uploadmyimage($filename,$index,$foldername,$newname){
 $allowedExts = array("gif", "jpeg", "jpg", "png");
 $extension = end(explode(".", $_FILES[$filename]["name"][$index]));
 if ((($_FILES[$filename]["type"][$index] == "image/gif")
 || ($_FILES[$filename]["type"][$index] == "image/jpeg")
 || ($_FILES[$filename]["type"][$index] == "image/jpg")
 || ($_FILES[$filename]["type"][$index] == "image/png"))
 && in_array($extension, $allowedExts))
 
 if ($_FILES[$filename]["error"][$index] > 0)
{

}
else
{
 move_uploaded_file($_FILES[$filename]["tmp_name"][$index], "img/".$foldername."/".$newname.".".$extension);
 $location="img/".$foldername ."/". $newname.".".$extension;
 return $location;
/*echo "Upload: " . $_FILES[$filename]["name"][$index] . "<br>";
  echo "Type: " . $_FILES[$filename]["type"][$index]. "<br>";
  echo "Size: " . ($_FILES[$filename]["size"][$index] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES[$filename]["tmp_name"][$index];

}
 
else
{
 //echo "Invalid file";*/
 }
}

?>