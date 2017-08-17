<?php include ("admin_header.php");
		include("db.php")?>
	
<body><div id="wrapcontent" >
<div class="container_div">
<h1 class="container_div_h1">Add New Movie</h1>
<form action="process.php" class="register" method="POST" enctype="multipart/form-data">
<input class="btn" style="position:absolute; left:900px;"type="submit" value ="SAVE">
	<div id="edit_div">
			<section class="section_top" >
				 <div id ="picture_div"><label for="upload">Upload profile picture</label><input id="upload"type="file" name="movieimg[]" onchange="readURL(this);" accept="image/*"><img id ="img_top_section"src=""/>
				</div>
				<div style ="width:450px;">
					<div ><input id="moviename" name="moviename" required="required" type="text" placeholder="movie name"/>
					</div>
					
					<div style="clear:both;"><label id="releasedate" for "releasedate" >Release date/year:</label> <input name="releasedate" id="releasedate" type="text" placeholder="0000 or dd/mm/yyyy" 
					pattern="^((((0[13578])|([13578])|(1[02]))[\/](([1-9])|([0-2][0-9])|(3[01])))|(((0[469])|([469])|(11))[\/](([1-9])|([0-2][0-9])|(30)))|((2|02)[\/](([1-9])|([0-2][0-9]))))[\/]\d{4}$|^\d{4}$"/> 
					<input list="genre" required="required" style="color:lightslategray;" name="genre" placeholder="genre" type="text" ><datalist id="genre">
  									<option value="Action">
  									<option value="Thriller">
  									<option value="Comedy">
  									<option value="Drama">
									<option value="Family">
 									<option value="Adventure">
									<option value="Romance">
									</datalist>
					</div>

					<div><TEXTAREA NAME="review" ROWS=5 COLS=55 placeholder="Enter movie plot/description here"></TEXTAREA></div>	
				</div>
				
			<div style="float:left; margin-top:50px;"><input style="margin-top:25px;" type="checkbox" name="intheater" value="1">In Theater<br>
					<input type="checkbox"style="margin-top:25px;" name="frontpage" value="true">In front page  
			</div>
	<div class="container_div">
	<p class="container_div_h1">Artists</p>
		<section style="width:650px;">
			<table id="roles_and_movie">
				<tr>
					<th></th>
						<th>Artist Name</th>
						<th>Role</th>
						<th>Movie Character</th></tr>
						<tr ><td><input type="checkbox" id="check"></td>
						<td><input size ="35"list="fullname" required="required" class="addnewartist" name="fullname[]" placeholder="Firstname Lastname" autocomplete="off">
															<datalist id="fullname">';		
															<?php
															$result=mysqli_query($conn,"SELECT CONCAT(firstName,' ',lastName) AS fullname FROM artist");
															$testarray = array();
															while($elements = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															
															echo '<option value="'.$elements['fullname'].'">';
															$testarray[]=array('fullname'=>$elements['fullname']);
															}
															mysqli_free_result($result);
															
															
															echo '</datalist>';?>
													</td>
													<td><input list="Roles" required="required" name="role[]" placeholder="Role in movie">
													<datalist id="Roles">
													<option value="Director">
													<option value="Writer">
													<option value="Producer">
													<option value="Lead-actor">
													<option value="Lead-actress">
													<option value="Actor">
													<option value="Actress">
													</datalist>
													</td>
													<td><input type="text" name="character[]"placeholder="Character in movie"></td></tr>';
													
		</table>
		<input type="button" id="addrow" value="Add new artist"><INPUT type="button" id="delete" value="Remove selected artists" />
</section>
</div>
</div>
</section>
</div>


<style>
#picture_div{
width:310px; position:relative;float:left;
}
#moviename{
font-size: 1.5em; -webkit-margin-before: 0.83em; -webkit-margin-after: 0.83em;


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

</form>
		
    </div>
	<div id="content" style="display:none;">
	<div class="container_div" style="color:grey">
     <h1 class= "container_div_h1" style="background: grey;
padding-top: 0px;line-height: 10px;">Add new Artist</h1>
			
			<h1>Artist Detail</h1>
			<div style="float:left;">
			<ul style="text-align: start;">
			<li>
			<label>First Name</label>
				<input type="text" required="required" name="newartistfn[]" placeholder="first name"></li>
				<li><label>Last Name</label>
				<input type="text" required="required" name="newartistln[]" placeholder="last name"></li>
				<li><label>Date of Birth</label>
				<input type="text" required="required" name="newartistdob[]" placeholder="Birth date"></li>
				<li><label>Date of Demise</label>
				<input type="text" name="newartistdod[]" placeholder=" "></li>
				<li><label>Nationality</label>
				<input type="text" required="required" name="newartistnat[]" placeholder="nationality"></li>
				 
				
			 </ul>
			</div>
			<div style="float:left;">
			<input style="position:absolute;left: 265px;top: 275px;"type="file" name="newartistimg[]" onchange="readURL(this);" accept="image/*">
			<img style ="width:150px; height:175px; border:1px solid grey; margin-right:10px;"src=""/>
			</div>
			<div style="clear:both;">
			<ul>
			<li><label>Biography</label></li>
				<li><textarea name="newartistbio[]" rows="4" cols="50" >Enter biography here</textarea></li>
				</ul>
			
			</div>
			<div style="clear:both;margin-bottom:20px; margin-left:30px;">
			
			<h1>In this movie</h1>
			<label for="Role">Role</label>
							<input list="Roles" required="required" name="newartistrole[]" placeholder="Role in movie" >
									<datalist id="Roles">
  									<option value="Director">
  									<option value="Writer">
  									<option value="Producer">
  									<option value="Lead-actor">
									<option value="Lead-actress">
 									<option value="Actor">
								</datalist>
							<label for="Character">Character</label>
							<input type="text" name="newartistchar[]" placeholder="Character in movie"></div>
            <input type="button" style ="background: url('cancel_button.png') no-repeat;position: absolute;top: 8px;left: 400px;"class="cancelButton" value=" "/>
</div>
</div>
</body>	<!--<li><label>Rating</label>
				<input type="text" name="rating" value="Rating"></li> !-->
<script>

$(document).ready(function () {

/*var arrayFromPHP = <?php echo json_encode($phpArray); ?>;
$.each(arrayFromPHP, function (i, elem) {
    // do your stuff
});*/
	
	/*$.getJSON('jasons.php','getmethis',function(json){
		varcheck = json;
	}).error(function(json) {
  console.log("Error!");
});*/
    
    $("#addrow").on("click", function () {
		//new row
        var row=$("table tr:first").next().clone();
		row.find("input:not(.ibtnDel)").val("").prop('disabled', false);
        row.show();
        row .appendTo("table");        
    });


	var varcheck=<?php echo json_encode($testarray); ?>;
	console.log(varcheck);
  $(document).delegate(".addnewartist",'blur',(function(){
  
  		var flag = 0;
  
  		for(var i = 0; i < varcheck.length; i++){
				
   			for(var ind in varcheck[i]) {
       				 for(var vals in varcheck[i][ind]){
           				  if(($(this).val())==(varcheck[i][ind])||($(this).val())==""){
						  	flag = 1;
							console.log(flag);
						  }
  
						 }
				}
			}
		if (flag == 0)	{
		
		alert('Oops! LOOKS LIKE WE DON\'T HAVE THE ARTIST ON OUR DATABASE. PLEASE ADD THE DETAILS ON THE BOX BELOW');
  		console.log($(this).val());
  		console.log(flag);
       var parentrow = $(this).parents('tr');
      parentrow.hide().find('input, textarea').prop('disabled', true);
      $(this).parents('tr').after('<tr/>').next().append('<td colspan=5"/>').children('td').append('<div/>').children().css('background','#f0f0f0','margin-top','30px','padding-top','20px').html($('#content').html());
  	}
	}));
  
  
    $(document).delegate(".cancelButton",'click',function(){
    var par= $(this).parents('tr');
	par.prev().find("input:not(.ibtnDel)").val("").prop('disabled', false);
	par.prev().find(".ibtnDel").prop('disabled', false);
	par.prev().show();
    $(this).parents('tr').remove();
    });
	$('#delete').click(function(){
        $('#roles_and_movie input:checkbox').each(function(){
          
            if(this.checked){
                if(($('#roles_and_movie tr').length)<=2){alert('At least one artist is required');}else{
                    $(this).parents("tr").remove();}
            }
        });
        return false;
    });
	
	
});

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







