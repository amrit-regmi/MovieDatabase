<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include('db.php');
{	
    $user=$_POST['username'];
    $pass=$_POST['password'];
    $fetch=mysqli_query($conn,"SELECT userId,firstName,lastName,userType,profilepic FROM user WHERE username='$user' and password='$pass'") or die(mysqli_error($conn));
    $num_row = mysqli_num_rows($fetch);
	$rowu=mysqli_fetch_assoc($fetch);
    if($num_row == 1)
    {	
		$_SESSION['login_username']=$rowu["userId"];
		$_SESSION['usertype']=$rowu['userType'];
		$_SESSION['fullname']=$rowu['firstName'].''.$rowu['lastName'];
		$_SESSION['username']=$rowu['firstName'];
		$_SESSION['login_profilepic']=$rowu['profilepic'];
		$_SESSION['Login_out']="Logout";
		
		if(isset($_SESSION['usertype'])){
			$userId=$_SESSION['login_username'];
			$fetch_fav=mysqli_query($conn,"SELECT movieCode FROM favourites WHERE userid='$userId'") or die(mysqli_error($conn));
			while($fav=mysqli_fetch_assoc($fetch_fav)){
			foreach($fav as $key){
			$favs[]=$key;
			}
			}
			$_SESSION['fav_movie']=$favs;
		}
		
		header('Location:'.$_SESSION['redirect']);
		exit;
    }
    else
    {echo $_POST['username'];
	echo $_POST['password'];
	echo $rowu["userId"];
  	 //header('Location:index.php');
    }

}
?>