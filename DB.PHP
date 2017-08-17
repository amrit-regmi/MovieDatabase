<?php
global $conn;
$conn = new mysqli("localhost","root","moviegallerypass","moviegallery");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>