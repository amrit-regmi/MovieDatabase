<!DOCTYPE html>
<?php session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
if(!($_SERVER['PHP_SELF']=='/phpproject/admin_login.php'||$_SERVER['PHP_SELF']=='/phpproject/register.php')){
$_SESSION['redirect']=$_SERVER['PHP_SELF'];}
?>
<html lang ="en-GB" >
<head>
	<meta charset ="utf-8">
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">	</script> 
</head>
<body>
<header>
<?php
if(!isset($_SESSION['login_username'])||$_SESSION['usertype']=="1")
	{
	echo "<script type=\"text/javascript\">".
  "window.alert('Stop!!! YOU are not Authorised to view this page');".
  "location = 'index.php';".
  "</script>"; 
	exit;
	}elseif($_SESSION['usertype']==0)
	{
?>
<div id="headerright">
			<a class="filldiv" onclick="window.location=('index.php')" ></a>
			<h1> NEPALICHALACHITRA.<span style="font: normal normal 18px Gruppo;">com</span>
				</h1>
				<p>&nbsp;Authentic Nepali Movie Reviews</p>
				
			</div>
			<nav >
				<ul >
					<li><a href="profile.php">Admin Home </a></li>
					<li ><a href="addmovie.php"> Add Movies </a></li>
					<li ><a href="addartist.php">Add Artists </a></li>
				</ul>
			</nav>
			<div id="headerleft">
			<div id="headerlefttop">
				<ul style="list-style-type:none; ">
					<li> Welcome <?php echo $_SESSION['username']; ?> &nbsp;&nbsp;&nbsp; </li>
					<li ><a href="admin_login.php?location=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" onclick="window.location=('logout.php')">Logout</a>&nbsp;&nbsp;&nbsp;</li>
					<li ><a href="register.php">Add admin</a>&nbsp&nbsp;&nbsp;</li>
					<li ><a href="userprofile.php">Watchlist</a>&nbsp;&nbsp;</li>
				</ul>
			</div>
			<div id="headerleftbottom">
				<form method="post" action="search.php" >
				<input type="text" name="search" placeholder ="Search movies and artists" size="25" id="search"/>
				<select id= "search" name="searchby">
					<option value="All">All</option>
					<option value="Movies">Movies</option>
					<option value="Artists">Artists</option>
				</select>
				<input type="submit" id="search"  value="Search"/>
				</form>
			</div>
			<hr style="clear:both;"></hr>
		</div>
		
		
</header>
<?php }?>




