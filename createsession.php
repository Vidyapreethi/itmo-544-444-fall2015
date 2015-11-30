<?php 
session_start(); 
echo $_POST['useremail'];
$_SESSION["email"] = $_POST['useremail'];
$_SESSION["phone"] = $_POST['phone'];
echo "Session variables are set.";

header('Location: /upload.php');    

?>
