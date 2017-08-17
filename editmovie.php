<?php include ("admin_header.php");
	  include ("db.php");
	$movieId = $_GET["movieCode"];
	  $movieresult=mysqli_query($conn,"(SELECT * FROM movie where movieCode= '$movieId')")or die(mysqli_error($conn));
	  $movie=mysqli_fetch_assoc($movieresult);
	  $genres = explode(',', $movie['genre']);
	  
		
echo '<div id="wrapcontent" >';
		$row1=mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname,artistId FROM  artist WHERE artistId=(SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and 
		role = 'Director')")or die(mysqli_error($conn));
		
		$row2= mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname, artistId FROM  artist WHERE artistId=(SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and 
		role = 'Writer') ")or die(mysqli_error($conn));
		
		$row3=mysqli_query($conn,"SELECT CONCAT(firstname,' ',lastname) AS fullname, artistId FROM  artist WHERE artistId IN (SELECT artistId FROM roles WHERE movieCode ='$movie[movieCode]' and 
		role LIKE '%lead%')")or die(mysqli_error($conn));
		
		$row4=mysqli_query($conn,"SELECT a.artistid,CONCAT(m.firstname,' ', m.lastname) AS fullname, a.role ,a.movieCharacter  FROM roles a, artist m WHERE a.moviecode = '$movie[movieCode]' AND a.artistid= m.artistid") or die(mysqli_error($conn));
		
		while($artist=mysqli_fetch_array($row4)){
		$artists[]=$artist;}
		
		$directerrow =mysqli_fetch_assoc($row1);
		$director=$directerrow ["fullname"];
		
		$writrrow =mysqli_fetch_assoc($row2);
		$writer=$writrrow["fullname"];
		
		while($actor=mysqli_fetch_array($row3)){
	 	$actors[]=$actor;
		}?>

<div class="container_div">
<form action="process.php" class="register" method="POST" enctype="multipart/form-data">
<input style="position:absolute;left: 790px;"class="btn" type="submit" value ="SAVE"/><a href="<?php echo $_SERVER['HTTP_REFERER']; ?> "style="position:absolute; left: 850px;"class="btn">CANCEL</a>
<input type="hidden" name="edit" value="<?php echo $movieId; ?>"/>
	<div id="edit_div">
			<section class="section_top" >
				<div id ="picture_div"><label for="upload">Change profile picture</label><input  id="upload"type="file" name="movieimg[]" onchange="readURL(this);" accept="image/*"><img id ="img_top_section"src="<?php echo $movie["image"];?>"/>
				</div>
				<div style ="width:450px;">
					
					<div ><input id="moviename" name="moviename" type="text" value="<?php echo $movie["title"];?>" placeholder="movie name"/>
					</div><?php if(isset($_SESSION['duplicate_msg'])){
					echo'<div><span style="color:red;">'.$_SESSION['duplicate_msg'].'</span></div>';
					unset($_SESSION['duplicate_msg']);

					}?>
					
					<div style="clear:both;"><label id="releasedate" for "releasedate" >Release date:</label> <input name="releasedate" id="releasedate" type="text"  value= "<?php echo $movie["releaseDate"];?>"/> <input list="genre" style="color:lightslategray;" name="genre" placeholder="genre" type="text" value="<?php
						echo $movie['genre'];
					?>"><datalist id="genre">
  									<option value="Action">
  									<option value="Thriller">
  									<option value="Comedy">
  									<option value="Drama">
									<option value="Family">
 									<option value="Adventure">
									</datalist>
					</div>

					<div><TEXTAREA name="plot" ROWS=5 COLS=55 > <?php echo ($movie["plot"]);?></TEXTAREA></div>	
				</div>
				
			<div style="float:left; margin-top:50px;"><input style="margin-top:25px;" type="checkbox" name="intheater" value="1" <?php if ($movie['inTheater']==1){echo 'checked="checked"';} ?>>In Theater<br>
					<input type="checkbox"style="margin-top:25px;" name="frontpage" value="1">In front page  
			</div>
	<div class="container_div">
	<p class="container_div_h1">Artists</p>
		<section class="table">
			<table id="roles_and_movie" style="width:100%">
				<tr>
					<th></th>
						<th>Artist Name</th>
						<th>Role</th>
						<th>Movie Character</th></tr>
					<?php foreach($artists as $artist){
						echo'<tr ><td><input type="checkbox" id="check"></td>
						<td><input list="fullname" required="required" class="addnewartist" name="fullname[]" placeholder="Firstname Lastname" autocomplete="off" value="'.$artist["fullname"].'">
															<datalist id="fullname">';		
															
															$result=mysqli_query($conn,"SELECT CONCAT(firstName,' ',lastName) AS fullname FROM artist");
															$testarray = array();
															while($elements = mysqli_fetch_array($result, MYSQLI_ASSOC)){
															
															echo '<option value="'.$elements['fullname'].'">';
															$testarray[]=array('fullname'=>$elements['fullname']);
															}
															mysqli_free_result($result);
															
															
															echo '</datalist>
													</td>
													<td><input list="Roles" required="required" name="role[]" value="'.$artist["role"].'">
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
													<td><input type="text" name="character[]" value="'.$artist["movieCharacter"].'"></td></tr>';
													}?>
		</table>
		<input type="button" id="addrow" value="Add new artist"><INPUT type="button" id="delete" value="Remove selected artists" />
</section>
</div>
</div>
</form>
</section>

</div>


<style>
#picture_div{
width:310px; position:relative;float:left;padding-left:10px;
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
font-size: 16px;
line-height: 0px;
margin-top: 0px;
padding-bottom: 5px;
}



</style>


	
<script>
$(document).ready(function () {
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
		
		alert('This artist doesnot exist on our database. Please add the artist first.');
  		console.log($(this).val());
  		console.log(flag);
       var parentrow = $(this).parents('tr');
		parentrow.find('.addnewartist').prop('value',"");
  	}
	})); 
    $("#addrow").on("click", function () {
        var row=$("table tr:first").next().clone().find("input").attr('value',"").end();
        row.show();
        row .appendTo("table");        
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
        
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
