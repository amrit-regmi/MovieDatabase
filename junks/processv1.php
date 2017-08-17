<?php
	include('db.php');	

	//ADD MOVIE PART
	if(isset($_POST)==true && empty($_POST)==false && isset($_POST['moviename'])){
	$title=$_POST['moviename'];
	$releasedate=$_POST['releasedate'];
	$genre=$_POST['genre'];
	$intheater=$_POST['intheater'];
	$plot=mysql_real_escape_string($_POST['plot']);
	//$rating=$_POST['rating'];
	$all_query_ok=true;
	mysqli_autocommit($conn, FALSE);
	
	if(isset($_POST['edit'])){  //if user sends the edited data from existing movie
	$moviecode=$_POST['edit'];
	$fetch=mysqli_query($conn,"select title from movie WHERE title='$title'")or die(mysqli_error($conn))? null : $all_query_ok=false;
	$num_row = mysqli_num_rows($fetch);
	if($num_row>0){
	echo 'nothing'; 
	}else{
		mysqli_query($conn,"");
		mysqli_query($conn,"DELETE FROM roles WHERE movieCode='$moviecode'")or die(mysqli_error($conn))? null :$all_query_ok=false;;
	}
	}
	else{
	mysqli_query($conn,"INSERT INTO movie (title,releaseDate,genre,image,plot,rating,inTheater) VALUES ('$title', '$releasedate','$genre','$uploadlocation_movieimg','$plot','$rating','$intheater')")or die(mysqli_error($conn))? null : $all_query_ok=false;
	$moviecode = mysqli_insert_id($conn);
	}
	
	
	
	
	$uploadlocation_movieimg= uploadmyimage("movieimg","0","moviepics",$title);
	
	
if(isset($_POST['fullname'])){ //relating existing artist to movie and adding to roles table
	$fullname=$_POST['fullname'];
	$role=$_POST['role'];
	$character=$_POST['character'];
	$existingartist_length = count($fullname);
	for($i=0; $i < $existingartist_length; $i++){
		$result=mysqli_query($conn,"SELECT artistId FROM artist WHERE CONCAT(firstName,' ',lastName)='$fullname[$i]'")or die(mysqli_error($conn))? null : $all_query_ok=false;
		$row =mysqli_fetch_assoc($result);
			if($row!="")
			{
			$artistId= $row["artistId"];
			mysqli_query($conn,"INSERT INTO roles (movieCode,artistId,role,movieCharacter) VALUES ('$moviecode','$artistId','$role[$i]','$character[$i]')")or die(mysqli_error($conn))? null : $all_query_ok=false;
			}
		}
	}
		
if(isset($_POST['newartistfn'])){ //relating new artist to movie and adding to artist and then to roles table

	$newartistfn=$_POST['newartistfn'];
	$newartistln=$_POST['newartistln'];
	$newartistdob=$_POST['newartistdob'];
	$newartistdod=$_POST['newartistdod'];
	$newartistnat=$_POST['newartistnat'];
	$newartistbio=$_POST['newartistbio'];
	$newartistrole=$_POST['newartistrole'];
	$newartistchar=$_POST['newartistchar'];

	
		$newartist_length = count($newartistfn);
		for($i=0; $i< $newartist_length; $i++)
		{
		$uploadlocation_movieimg= uploadmyimage("newartistimg","$i","moviepics",$newartistfn[$i].$newartistln[$i]);
		mysqli_query($conn,"INSERT INTO artist (firstName,lastName,dob,dod,nationality,Biography,image) VALUES ('$newartistfn[$i]', '$newartistln[$i]','$newartistdob[$i]','$newartistdod[$i]','$newartistnat[$i]','".mysql_real_escape_string($newartistbio[$i])."','$uploadlocation_movieimg')")or die(mysqli_error($conn))? null : $all_query_ok=false;
		echo mysqli_error($conn);
		$artistId=mysqli_insert_id($conn);
		mysqli_query($conn,"INSERT INTO roles (movieCode,artistId,role,movieCharacter) VALUES ('$moviecode','$artistId','$newartistrole[$i]','$newartistchar[$i]')")or die(mysqli_error($conn))? null : $all_query_ok=false;
		echo mysqli_error($conn);
		}
	}else{echo "error";}
		
		if($all_query_ok){
			mysqli_commit($conn);
			mysqli_autocommit($conn, TRUE);
			header('Location:profile.php');	
			
		}else{
			mysqli_rollback($conn);
			echo mysqli_error($conn);
			header('Location:addmovie.php');
			}
	
	}
	
	elseif(isset($_POST)==true && empty($_POST)==false && isset($_POST['fname'])){ //adding new artist only
		//ADD ARTIST PART
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$dob=$_POST['dob'];
		$dod=$_POST['dod'];
		$nationality=$_POST['nationality'];
		$biography= mysql_real_escape_string($_POST['biography']);
		
		
		$all_query_ok=true;
		mysqli_autocommit($conn, FALSE);
	
		$uploadlocation= uploadmyimage("file","0","artistpics",$fname.$lname);

		mysqli_query($conn,"INSERT INTO artist (firstName,lastName,dob,dod,nationality,image,Biography) VALUES ('$fname', '$lname','$dob','$dod','$nationality','$uploadlocation','$biography')")or die(mysqli_error($conn))? null : $all_query_ok=false;
		$artistcode = mysqli_insert_id($conn);
		
		if($all_query_ok){
			mysqli_commit($conn);
			mysqli_autocommit($conn, TRUE);
			header('Location:profile.php');
				
			
		}else{
			mysqli_rollback($conn);
			header('Location:addartist.php');
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
*/
}
 
else
{
 //echo "Invalid file";
 }
}

?>