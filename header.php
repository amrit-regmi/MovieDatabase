<!DOCTYPE html>

<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include('session.php');
if(!($_SERVER['PHP_SELF']=='/phpproject/admin_login.php'||$_SERVER['PHP_SELF']=='/phpproject/register.php'||$_SERVER['PHP_SELF']=='/phpproject/contact.php')){
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
	<header >
			<div id="headerright">
			<h1><a class="filldiv" href="index.php"></a>
					 NEPALICHALACHITRA.<span style="font: normal normal 18px Gruppo;">com</span>
				</h1>
				<p style="font-size:12px;">&nbsp;Authentic Nepali Movie Reviews</p>
			
			</div>
			<nav >
				<ul >
					<li><a href="index.php"> Home </a></li>
					<li ><a href="movies.php"> Movies </a></li>
					<li ><a href="artist.php">Artists </a></li>
					<?php if($_SESSION['usertype']==0&&$_SESSION['usertype']!=""){
					 echo '<li ><a href="profile.php">ADMIN</a></li>';}else{
					echo '<li >'; 
					if (!isset($_SESSION['login_username']))
					{
					echo '<a href="#" onClick="alert(\'please login to view the watchlist\')"';
					}else echo '<a href="userprofile.php"';
					echo '>WATCHLIST</a></li>';}?>
				</ul>
			</nav>
			<div id="headerleft">
			<div id="headerlefttop">
				<ul style="list-style-type:none; overflow:hidden; ">
					<li> Welcome <?php echo $_SESSION['username']; ?> &nbsp;&nbsp;&nbsp; </li>
					<li ><a href="admin_login.php<?php echo '?redirect='.$_SERVER['REQUEST_URI'].'">'.$_SESSION['Login_out']; ?></a>&nbsp;&nbsp;&nbsp;</li>
					<li ><a href="register.php">Register</a>&nbsp&nbsp;&nbsp;</li>
					<li ><a href="contact.php">contact us</a>&nbsp;&nbsp;</li>
					
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

