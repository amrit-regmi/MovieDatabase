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
<form id="register" style="position:relative; margin:auto; width:800px;" action="process.php" method="POST" enctype="multipart/form-data" >
				<ul>
					<li>
					<label for="fname">First name:</label><br>
					<input type="text" name="userfname" id="fname" pattern="^[A-Za-z]+([ ][A-Za-z]+)?$" required="required">
					
					</li>
					<li>
					
					<label for="lname">Last name:</label><br>
					<input type="text" name="userlname" id="lname" pattern="^[A-Za-z]+([ ][A-Za-z]+)?$" required="required">
					
					</li>
					<li>
					<label for="uname">Username:</label><br>
					<input type="text" name="uname" id="uname" pattern="^[a-z0-9_-]{5,10}$" required="required" placeholder="username"><a href="#" style="display:inline; font-weight:bold;"id="help">?</a><div>&nbsp;&nbsp;"username should be 5-10 characters long and can contain digits letters and speceial characters - , _  "&nbsp;&nbsp;</div>
					</li>
					<li>
					<label for="password">Password:</label><br>
					<input type="password" name="userPassword" id="fname" pattern="^.{5,10}$" required="required" placeholder="username"><a href="#" style="display:inline; font-weight:bold;"id="help">?</a><div>&nbsp;&nbsp;"password should be 5-10 characters long and can contain digits letters and speceial characters "&nbsp;&nbsp;</div>
					</li>
					
					<?php if(isset($_SESSION['usertype']) && $_SESSION['usertype']==0){  ?>
					<li>
					<label for="usertype">Usertype</label><br>
							<select id= "usertype" name="usertype">
							<option value="0">Administrator</option>
							<option value="1">User</option>
							</select>
					</li>
					<?php } ?>
					<li>
					<div>
					<label for="upload">Profile picture</br></label>
					<img style="width:100px;height:100px;"src=""></br>
					<input id="upload" type="file" name="userimg[]" onchange="readURL(this);" accept="image/*">
					</div>
					</li>
					<li>
					<input type="hidden" name="register" value="true"/>
					<input class="btn"type="submit"   value="REGISTER"/>
					</li>
				</ul>
				
						
		</form>
		<?php echo $_SESSION['error'];?>
			</div>
		</body>
	</div>
	<style>
	#register input {
		width:375px;
		display:inline;
		border: 1px solid #999;
		height: 25px;
		box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
		}
	#help:hover + div{
	display:block;
	
	
	}
	#help + div{
	width:375px;
	height:40px;
	border:1px solid red;
	overflow:auto;
	display:none;
	box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	color:blue;
	
	}
	</style>
	<script>
		 function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                     $(input).prev().prev('img').attr('src', e.target.result)
        
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
	</script>
	</html>