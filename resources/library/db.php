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

        print "</p>============</p>EndPoint". $endpoint . "</p>================</p>";

        $link = mysqli_connect($endpoint,"controller","ilovebunnies","customerrecords") or die("Error " . mysqli_connect_error($link));

        return $link;
}

function isSubscribed($email) {

        $conn = getDbConn();

		$sql = "SELECT * FROM ITEMS where EMAIL='".$email."' and ISSUBSCRIBED=1";
		
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

        $conn = getDbConn();

		$sql = "SELECT * FROM ITEMS where EMAIL='".$email."' and ISSUBSCRIBED=1";
		
		$sql = "UPDATE ITEMS SET ISSUBSCRIBED=1 WHERE EMAIL='".$email."'";

		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		
		$conn->close();
}
?>