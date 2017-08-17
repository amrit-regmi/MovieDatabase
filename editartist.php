<?php include ("admin_header.php");
$artist=$_GET['artist'];
?>	
	<body><div id="wrapcontent" > 
		<div class="container_div">
		
		<h1 class="container_div_h1">Add New Movie</h1>
        <form action="process.php" class="register" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="edit" value="<?php echo $artist['artistId'];?>"/>
		   <input style="position:absolute;left: 790px;"class="btn" type="submit" value ="SAVE"/><a href="<?php echo $_SERVER['HTTP_REFERER']; ?> "style="position:absolute; left: 850px;"class="btn">CANCEL</a>

			<div id="edit_div">
			<section class="section_top" >
				 <div id ="picture_div"><label for="upload">Upload profile picture</label><input id="upload"type="file" name="file[]" onchange="readURL(this);" accept="image/*"><img id ="img_top_section"src="<?php echo $artist['image'] ?>"/>
				</div>
				<div style ="width:450px;margin-top:35px;">
				<div ><label id="fname" for "fname" >First name  </label><input id="fname" name="fname" required="required" type="text" placeholder="first name"value="<?php echo $artist['firstName'] ?>"/>
					</div>
				<div ><label id="lname" for "lname" >Last name  </label><input id="lname" name="lname" required="required" type="text" placeholder="last name"/ value="<?php echo $artist['lastName'] ?>">
					</div>
				<div><label for "dob" id="dob">Date of Birth </label>
				<input id="dob" type="text" name="dob" placeholder="dd/mm/yyyy or yyyy" 
				pattern="^((((0[13578])|([13578])|(1[02]))[\/](([1-9])|([0-2][0-9])|(3[01])))|(((0[469])|([469])|(11))[\/](([1-9])|([0-2][0-9])|(30)))|((2|02)[\/](([1-9])|([0-2][0-9]))))[\/]\d{4}$|^\d{4}$"
				
				value="<?php echo $artist['dob'] ?>" ></div>
				<div><label id ="dod" for "dod">Date of Demise </label>
				<input id ="dod" type="text" name="dod" placeholder="dd/mm/yyyy or yyyy" 
				pattern="^((((0[13578])|([13578])|(1[02]))[\/](([1-9])|([0-2][0-9])|(3[01])))|(((0[469])|([469])|(11))[\/](([1-9])|([0-2][0-9])|(30)))|((2|02)[\/](([1-9])|([0-2][0-9]))))[\/]\d{4}$|^\d{4}$" value="<?php echo $artist['dod'] ?>"></div>
				<div><label  id="nationality" for "nationality" >Nationality </label>
				<input id="nationality" type="text" name="nationality" placeholder="nationality" value="<?php echo $artist['nationality'] ?>"></div>
				<div><TEXTAREA NAME="biography" ROWS=9 COLS=55 placeholder="Enter Biography here"><?php echo $artist['Biography'] ?></TEXTAREA></div>
		</form>
		
    </div></body>
<style>
#picture_div{
width:310px; position:relative;float:left;
}
#fname,#lname,#dob,#dod,#nationality{
font-size: 1.3em; -webkit-margin-before: 0.83em; -webkit-margin-after: 0.83em;


}
#releasedate_label{
color: #3299BB;
font-size: 16px;
line-height: 0px;
margin-top: -12px;
padding-bottom: 5px; 
}
#releasedate{
color: #3299BB;
font-size: 14px;
line-height: 19px;
margin-top: 0px;
padding-bottom: 0
}



</style>
<script> 
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                     $(input).next('img').attr('src', e.target.result)
            }
                };

                reader.readAsDataURL(input.files[0]);
				
        }
</script> 

</html>







