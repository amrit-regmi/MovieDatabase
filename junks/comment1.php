<?php include('header.php');
	if(isset($_SESSION['login_username'])){
		$login=true;
}else{
$login=false;
}

?>
<div>
<div id="wrapcontent" >
<input type="hidden" id="moviecode" value="119"/>
<?php
	if (in_array('119',$_SESSION['fav_movie'])){
	echo '<input type="button" class="btn" id="fav" style="background-color:green;" value="REMOVE FROM WATCHLIST">';
	
	}else{
	echo '<input type="button" class="btn" id="fav" value="ADD TO WATCHLIST">';
} ?>
</div>	</div></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">	</script> <script type="text/javascript" >
$(function() {
$("#fav").click(function() 
{
var login=<?php echo $login ?>;
var clicked=this
if (login==true){
var command=$(clicked).val();
var movieCode=$(clicked).prev("#moviecode").val();
var dataString ='&fav_movieCode='+movieCode+'&favourite='+command;
$.ajax({
type: "POST",
url:"process.php",
data: dataString,
cache: false,
success: function(html){
if ($(clicked).val()=="ADD TO WATCHLIST"){
		$(clicked).val("REMOVE FROM WATCHLIST");
		$(clicked).css('background','green');
	}else{	
	$(clicked).val("ADD TO WATCHLIST");
	$(clicked).css('background','#3299BB');
	
	}

console.log(dataString);
}
});
return false;
}
else{
alert("please login first to add to watchlist");
}
}); });
</script>