
<?php include ("header.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include('SESSION.php'); 
if(isset($_SESSION['login_username'])){
		session_start();
		if(session_destroy())
		{
		session_start();
		$_SESSION['username']="Guest";
		$_SESSION['Login_out']="Login";
		$_SESSION['login_profilepic']="img\userpics\avatar.jpg";
		header("Location: index.php");
		exit();
		}
		}else{
 
 ?>
<html lang ="en-GB" >
<head>
	<meta charset ="utf-8">
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<div id="wrapcontent">
  <div class="login" style="background: honeydew;">
    <h1>Login</h1>
     <form id="loginform"method="post" name="login" action="LOGIN.php">
		<input type="text" name="username" id="userid" required="required" placeholder="USERNAME"/><br />
		<input type="password" name="password" id="passid" required="required" placeholder="PASSWORD"  /><br />
		<input type="submit" class="btn" name="submit" id="submit"  value="Login" />
		<input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect']);?>"/> 
	</form>
  </div>

</div>

</html>
<?php }
?>

<style>
.login {
  margin: 50px auto;
  width: 640px;
  height:210px;
  border-radius:10px;
}
.login h1 {
  line-height: 40px;
  font-size: 15px;
  font-weight: bold;
  color: #555;
  text-align: center;
  text-shadow: 0 1px white;
  background: #f3f3f3;
  border-bottom: 1px solid #cfcfcf;
  border-radius: 3px 3px 0 0;
  background-image: -webkit-linear-gradient(top, whiteffd, #eef2f5);
  background-image: -moz-linear-gradient(top, whiteffd, #eef2f5);
  background-image: -o-linear-gradient(top, whiteffd, #eef2f5);
  background-image: linear-gradient(to bottom, whiteffd, #eef2f5);
  -webkit-box-shadow: 0 1px whitesmoke;
  box-shadow: 0 1px whitesmoke;
}
 
.login p {
  margin: 20px 0 0;
}
 
.login p:first-child {
  margin-top: 0;
}
 
.login input[type=text], .login input[type=password] {
  width: 278px;
  margin: 5px;
  padding: 0 10px;
  width: 200px;
  height: 34px;
  color: #404040;
  background: white;
  border: 1px solid;
  border-color: #c4c4c4 #d1d1d1 #d4d4d4;
  border-radius: 2px;
  outline: 5px solid #eff4f7;
  -moz-outline-radius: 3px;
  -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
}
#loginform{
margin:auto;
width:212px;
}
.login input[type=submit]{
margin-top:10px;

}

 
  
 
</style>


