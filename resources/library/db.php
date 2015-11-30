<?php

function getDbConn() {

    $rds = new Aws\Rds\RdsClient([
        'version' => 'latest',
        'region'  => 'us-east-1'
    ]);

    $result = $rds->describeDBInstances([
        'DBInstanceIdentifier' => 'pvp-db-mp',
    ]);

    $endpoint = $result['DBInstances'][0]['Endpoint']['Address'];

    //print "</p>============</p>EndPoint: ". $endpoint . "</p>================</p>";

    $link = mysqli_connect($endpoint,"controller","ilovebunnies","customerrecords") or die("Error " . mysqli_connect_error($link));

    return $link;
}

function isSubscribed($email) {

	$email = strtolower($email);

    $conn = getDbConn();

	$sql = "SELECT * FROM items where email='".$email."' and issubscribed=1";
	
	$result = $conn->query($sql);
		
	$rows = $result->num_rows;
	
	$conn->close();
		
	if ($rows > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function setSubscribed($email) {

	$email = strtolower($email);
		
    $conn = getDbConn();

	$sql = "UPDATE items SET issubscribed=1 WHERE email='".$email."'";

	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
		
	$conn->close();
}

function isReadOnlyMode() {

    $conn = getDbConn();

	$sql = "SELECT * FROM cloud_gallery_config WHERE config_key='IS_READ_ONLY_MODE' AND config_value='1'";
	
	$result = $conn->query($sql);
		
	$rows = $result->num_rows;
	
	$conn->close();
		
	if ($rows > 0) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function toggleMode() {

    $conn = getDbConn();

	$sql = "SELECT * FROM cloud_gallery_config WHERE config_key='IS_READ_ONLY_MODE'";
	
	$result = $conn->query($sql);
		
	$rows = $result->num_rows;
	
	if($rows > 0) {
		if(isReadOnlyMode()) {
			$sql = "UPDATE cloud_gallery_config SET config_value='0' WHERE config_key='IS_READ_ONLY_MODE'";	
		} else {
			$sql = "UPDATE cloud_gallery_config SET config_value='1' WHERE config_key='IS_READ_ONLY_MODE'";	
		}
	} else {
		$sql = "INSERT into cloud_gallery_config (config_key, config_value) VALUES ('IS_READ_ONLY_MODE', '1')";
	}
	

	$conn->query($sql);
		
	$conn->close();
}
?>