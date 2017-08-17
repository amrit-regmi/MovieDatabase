<?php include ('db.php')
if($_POST)
{

$comment=$_POST['comment'];
$moviecode = $_POST['moviecode'];
mysql_query($conn,"INSERT INTO comment
VALUES ($comment, $moviecode");
}
else { }
?>
