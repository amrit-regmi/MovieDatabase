<?php 	session_start();
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		include('db.php');
		if(isset($_SESSION['login_username'])&&$_SESSION['usertype']=="0") {
		include ("admin_header.php");
		}
		else{
		include ("header.php");
		}?>
<div id="wrapcontent">
<body>
<div class="container_div">
<form id="contactform" name="contactform" method="post" action="email.php">
 <ul>
 <li>
  <label for="first_name">First Name</label> 
  <input  type="text" name="first_name" maxlength="50" size="40" required="required">
 </li>  
  <label for="last_name">Last Name</label>
  <input  type="text" name="last_name" maxlength="50" size="40" required="required">
 <li>
  <label for="email">Email Address</label>
  <input  type="email" name="email" maxlength="80" size="35" required="required">
 </li>
  <label for="telephone">Telephone Number</label>
  <input  type="tel" name="telephone" maxlength="30" size="30">
 <li>
  <label for="comments">Comments</label>
 </li>
 <li>
 <textarea  name="comments" maxlength="1000" cols="55" rows="6" required="required"></textarea>
 </li>
 <li>
  <input class="btn" type="submit" value="Submit">
  </li>
 </ul>
</form>

</div>
</div>
<style>
	#contactform{
	width:300px;
	}

	#contactform input{
	width: 278px;
  margin: 10px;
  margin-left:40px;
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
	#contactform label{
	 font-weight:bold;
	
	}
</style>