<?php include ("admin_header.php");?>	
	<body><div id="wrapcontent" > 
        <form action="process.php" class="register" method="POST" enctype="multipart/form-data">
			<h1>Add new Movie</h1>
			<fieldset class ="moviedetails">
			<legend>Movie detail</legend>
		<div style="float:left;">
			<ul>
			<li>
			<label>Title</label>
				<input type="text" required="required" name="moviename" value="Movie name"></li>
				<li><label>Release Date/year</label>
				<input type="text" required="required" name="releasedate" value="Release Date/year"></li>
				<li><label for="Genre">Genre</label>
					<input list="genre" required="required" class="small"  name="genre"></li>
									<datalist id="genre">
  									<option value="Action">
  									<option value="Thriller">
  									<option value="Comedy">
  									<option value="Drama">
									<option value="Family">
 									<option value="Adventure">
									</datalist>
				<li><label for="intheater">In theater</label>
				<select name="intheater">
					<option></option>
					<option> Yes </option>
					<option> No </option>
					</select></li>
				<li><label>Rating</label>
				<input type="text" name="rating" value="Rating"></li>
				<li><label>CoverImage</label>
				 <input type="file" name="movieimg[]" accept="image/*"></li>
				
			</ul>
		</div>
		<div style="float:left;">
			<img style ="width:150px; height:175px; border:1px solid black;margin-left:150px;"src=""/>
			</div>
		   <div style="clear:both;">
			<ul>
			<li><label>Plot/Description</label></li>
				<li><textarea name="plot" rows="4" cols="85" >Enter movie plot here</textarea></li>
				</ul>
			
		</div>
	</fieldset>
			
            <fieldset class="artistdetails">
				<legend>Artists</legend>
               <table id="myTable" class="order-list">
    <thead>
 
       
    </thead>
    <tbody>
                    <tr>
						<td>
							<label>Full name</label>
							<input list="fullname" required="required" class="addnewartist" name="fullname[]" placeholder="Firstname Lastname" autocomplete="off">
									<datalist id="fullname">
									
  									<?php include ("DB.php");

									$result=mysqli_query($conn,"SELECT CONCAT(firstName,' ',lastName) AS fullname FROM artist");
									$testarray = array();
									while($elements = mysqli_fetch_array($result, MYSQLI_ASSOC)){
									
									echo '<option value="'.$elements['fullname'].'">';
									$testarray[]=array('fullname'=>$elements['fullname']);
									}
									mysqli_free_result($result);
									
									?>
									</datalist>
						 
						 
						 </td>
						 <td>
							<label for="Role">Role</label>
							<input list="Roles" required="required" name="role[]">
									<datalist id="Roles">
  									<option value="Director">
  									<option value="Writer">
  									<option value="Producer">
  									<option value="Lead-actor">
									<option value="Lead-actress">
 									<option value="Actor">
									</datalist>

					     </td>
						 <td>
							<label for="Character">Character</label>
							<input type="text" name="character[]" >
	
						 </td>
							
                    </tr>
                    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: left;">
                <input type="button" id="addrow" value="Add Row" />
            </td>
        </tr>
    </tfoot>
</table>
			
    </fieldset>
   
      
<input class="submit" type="submit" value="Confirm &raquo;" />
</form>
		
    </div>
	<div id="content" style="display:none;">
     <h1>Add new Artist</h1>
			
			<h1>Artist Detail</h1>
			<div style="float:left;">
			<ul>
			<li>
			<label>First Name</label>
				<input type="text" required="required" name="newartistfn[]" value="first name"></li>
				<li><label>Last Name</label>
				<input type="text" required="required" name="newartistln[]" value="last name"></li>
				<li><label>Date of Birth</label>
				<input type="text" required="required" name="newartistdob[]" value="Birth date"></li>
				<li><label>Date of Demise</label>
				<input type="text" name="newartistdod[]" value=" "></li>
				<li><label>Nationality</label>
				<input type="text" required="required" name="newartistnat[]" value="nationality"></li>
				<li><label>CoverImage</label>
				 <input type="file" name="newartistimg[]" accept="image/*"></li>
				
			 </ul>
			</div>
			<div style="float:left;">
			<img style ="width:150px; height:175px; border:1px solid black;margin-left:150px;"src=""/>
			</div>
			<div style="clear:both;">
			<ul>
			<li><label>Biography</label></li>
				<li><textarea name="newartistbio[]" rows="4" cols="85" >Enter biography here</textarea></li>
				</ul>
			
			</div>
			<h1>In this movie</h1>
			<label for="Role">Role</label>
							<input list="Roles" required="required" name="newartistrole[]">
									<datalist id="Roles">
  									<option value="Director">
  									<option value="Writer">
  									<option value="Producer">
  									<option value="Lead-actor">
									<option value="Lead-actress">
 									<option value="Actor">
									</datalist>
							<label for="Character">Character</label>
							<input type="text" name="newartistchar[]" >
            <input type="button" class="cancelButton" value="Cancel"/>
</div>
</body>
<script>

$(document).ready(function () {

/*var arrayFromPHP = <?php echo json_encode($phpArray); ?>;
$.each(arrayFromPHP, function (i, elem) {
    // do your stuff
});*/
	var varcheck=<?php echo json_encode($testarray); ?>;
	 console.log(varcheck);
	/*$.getJSON('jasons.php','getmethis',function(json){
		varcheck = json;
	}).error(function(json) {
  console.log("Error!");
});*/
    
    $("#addrow").on("click", function () {
		//new row
        var row=$("table tr:first").clone();
		row.find("input:not(.ibtnDel)").val("").prop('disabled', false);
        row.show();
        var col = '<td><input type="button" class="ibtnDel"  value="Delete"></td>';  //delete button
        row.append(col); 
        row .appendTo("table");        
    });
    $(".order-list").on('click', ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
    });
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
});


</script> 


</html>







