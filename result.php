<?php
// Start the session
session_start();
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
echo $_POST['useremail'];
$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}
echo 'Here is some more debugging info:';
print_r($_FILES);
print "</pre>";
require 'vendor/autoload.php';
#use Aws\S3\S3Client;
#$client = S3Client::factory();
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

use Aws\Sns\SnsClient;
$sns = SnsClient::factory(array(
'version' => 'latest',
'region' => 'us-east-1'
));

$bucket = uniqid("php-pv-",false);
#$result = $client->createBucket(array(
#    'Bucket' => $bucket
#));
# AWS PHP SDK version 3 create bucket
$result = $s3->createBucket([
    'ACL' => 'public-read',
    'Bucket' => $bucket
]);
#$client->waitUntilBucketExists(array('Bucket' => $bucket));
#Old PHP SDK version 2
#$key = $uploadfile;
#$result = $client->putObject(array(
#    'ACL' => 'public-read',
#    'Bucket' => $bucket,
#    'Key' => $key,
#    'SourceFile' => $uploadfile 
#));
# PHP version 3
$result = $s3->putObject([
    'ACL' => 'public-read',
    'Bucket' => $bucket,
   'Key' => $uploadfile,
	'SourceFile' => $uploadfile 
]); 

$url = $result['ObjectURL'];
echo $url;

$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'pvp-db-mp',
    #'Filters' => [
    #    [
    #        'Name' => '<string>', // REQUIRED
    #        'Values' => ['<string>', ...], // REQUIRED
    #    ],
        // ...
   # ],
   # 'Marker' => '<string>',
   # 'MaxRecords' => <integer>,
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
    echo "<p>============</p>". $endpoint . "<p>================</p>";
//echo "begin database";

$link = mysqli_connect($endpoint,"controller","ilovebunnies","customerrecords") or die("Error" . mysqli_connect_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* Prepared statement, stage 1: prepare */
if (!($stmt = $link->prepare("INSERT INTO items (id, email,phone,filename,s3rawurl,s3finishedurl,status,issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))) {	
    echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}
$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl = $url; //  $result['ObjectURL']; from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$status =0;
$issubscribed=0;
$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
printf("%d Row inserted.\n", $stmt->affected_rows);
/* explicit close recommended */
$stmt->close();
$link->real_query("SELECT * FROM items");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}

$link->close();
//add code to detect if subscribed to SNS topic 

// creating sns topic
$topicArn = $sns->createTopic([
'Name' => 'MP2-sns-test',
]);

echo "<p/>";
echo "ARN is:";
echo $topicArn['TopicArn'];

$topicAttributes = $sns->setTopicAttributes([
'TopicArn' => $topicArn['TopicArn'],
'AttributeName'=>'DisplayName',
'AttributeValue'=>'MP2-alert',
]);

echo "<p/>";
echo "Created display name";

$topicSubscribe = $sns->subscribe(array(
    // TopicArn is required
    'TopicArn' => $topicArn['TopicArn'],
    // Protocol is required
    'Protocol' => 'email',
    'Endpoint' => $email,
));

echo "<p/>";
echo "Please check your email and confirm subsciption";

$topicResult = $sns->publish(array(
    'TopicArn' => $topicArn['TopicArn'],
    'TargetArn' => $topicArn['TopicArn'],

    'Message' => 'S3 bucket successfully created',
    'Subject' => 'Important-regarding S3',

));
echo "Published email.Please check your email";


//if not subscribed then subscribe the user and UPDATE the column in the database with a new value 0 to 1 so that then each time you don't have to resubscribe them
// add code to generate SQS Message with a value of the ID returned from the most recent inserted piece of work
//  Add code to update database to UPDATE status column to 1 (in progress)
?>
