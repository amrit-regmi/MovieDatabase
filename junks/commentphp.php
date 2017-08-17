<?php include('db.php');
$comment=$_POST['comment'];
$moviecode = $_POST['moviecode'];
mysqli_query($conn,"INSERT INTO comment(comment,moviecode) VALUES ('$comment', '$moviecode')")or die(mysqli_error($conn));
mysqli_commit($conn);
?>
