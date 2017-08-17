<div><form id="userreviewinput" action="#" method="post" >
			<TEXTAREA style="border-radius: 3px; border: 1px solid #ccc; font:-webkit-small-control; font-size: 13px; background:#ddd;" NAME="review" ROWS=3 COLS=57 id="review"> Post your reviews and comments here ...</TEXTAREA>		
			<input type="hidden" name="moviecode" value="119" >
			<input type="submit" class="cmt_btn" value="Post your review">
</form>
<div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">	</script> <script type="text/javascript" >
$(function() {
$(".cmt_btn").click(function() 
{
var comment = $(this).parent().find('cmt_btn').val();
var moviecode=$(this).parent().find('moviecode').val()
var dataString = 'comment='+ comment + 'moviecode=' + moviecode;
$.ajax({
type: "POST",
url: "commentphp.php",
data: dataString,
cache: false,
success: function(html){
console.log('success');
}
});
return false;
}); });
</script>