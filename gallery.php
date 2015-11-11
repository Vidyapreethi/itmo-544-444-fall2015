<html>
<head><title>Gallery</title>
</head>
<body>

<?php
session_start();
$email = $_POST["email"];
echo $email;
require 'vendor/autoload.php';

$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

// Create a table 
$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'pvp-db-mp',
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
print "============\n". $endpoint . "================\n";

$link = mysqli_connect($endpoint,"controller","ilovebunnies","customerrecords") or die("Error " . mysqli_connect_error($link));  


//below line is unsafe - $email is not checked for SQL injection -- don't do this in real life or use an ORM instead
$link->real_query("SELECT * FROM items WHERE email = '$email'");
//$link->real_query("SELECT * FROM items");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    
    echo "<img src =\" " . $row['s3rawurl'] . "\" />";
    //echo "<img src =\"" .$row['s3finishedurl'] . "\"/>";#Finished URL not set
    echo "<p>".$row['id'] . "Email: " . $row['email']."</p>";
}
$link->close();
?>
</body>
</html>
