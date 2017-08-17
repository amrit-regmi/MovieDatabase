<!DOCTYPE html>
<?php
include('session.php');
?>

<html lang ="en-GB" >
<head>
	<meta charset ="utf-8">
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<?php 
	if(!isset($login_session))
	{	
?>
	</head>
<body>
<header>
<div class="wrap">
<div id= headerleft>
	<img id = logo src="logo.png"/>

</div>
<div id="empty_space_header"></div>

<input type="button" class="search_submit"  onclick="window.location=('admin_login.php');" value="Login"/>
<input type="button" class="search_submit" onclick="window.location=('http://www.google.com');" value="Register">



</div>

</header>
<div class="seperator">
</div>
<nav>
		<div class="wrap">
			<ul>
				<li><a href="index.php"> Home </a></li>
				<li><a href="movies.php"> Movies </a></li>
				<li><a href="Program.html"> Celebraties </a></li>
				<li><a href="events.html"> My Movies </a></li>
				
			</ul>
			<div id= searchdiv>
			<form id= search>
			
			<input type="text" name="search" value ="Search for movies and celebreties" size="37" id="search"/>
			<select id= "searchby">
				<option value="All">All</option>
 				 <option value="Movies">Movies</option>
 				 <option value="Stars">Stars</option>
				
			</select>
			<input type="submit" class="search_submit"  value="SEARCH"/>
			
			</form>
			</div>
			
		</div>
	</nav>
	<div class="seperator" style="height:3px";>
</div>
	
<?PHP }else
	{
	include('admin_header.php');
	//header("Location:profile.php");
	}
?>	
