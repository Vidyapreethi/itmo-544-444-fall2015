<?php
require 'vendor/autoload.php';
require 'resources/library/db.php';

$email = $_POST['email'];

echo "Adding Email".$email." as a confirmed Subscriber to email alerts";

setSubscribed($email);
?>