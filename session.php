<?php 
session_start();
if(!isset($_SESSION['username'])){
$_SESSION['Login_out']="Login";
$_SESSION['username']="Guest";
$_SESSION['login_profilepic']="img\userpics\avatar.jpg";
}?>