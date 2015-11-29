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
?>