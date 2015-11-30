<?php
session_start();
include 'header.php';

echo "</p> Created Session Variables</p>";

echo "</p>User Email: ".$_SESSION["email"];
echo "</p>User Phone: ".$_SESSION["phone"];

include 'footer.php';
?>