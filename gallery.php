<?php
session_start();
include 'header.php';
?>
	<!-- Foundation.js -->
	<script>
      		$(document).foundation();
    	</script>

	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

	<!-- Fotorama -->
	<link href="resources/css/fotorama.css" rel="stylesheet">
	<script src="resources/js/fotorama.js"></script>
  
<?php
$email = $_SESSION["email"];

echo "Entered email:  ".$email;

require 'vendor/autoload.php';
require 'resources/library/db.php';

$link = getDbConn();


//below line is unsafe - $email is not checked for SQL injection -- don't do this in real life or use an ORM instead
$link->real_query("SELECT * FROM items WHERE email = '$email'");

$res = $link->use_result();

echo "<p/>";
echo "Result set order:\n";

//echo "<div class=\"fotorama\" data-width=\"700\" data-ratio=\"700/467\" data-max-width=\"100%\">";
echo "<div class=\"fotorama\">";
while ($row = $res->fetch_assoc()) {
    
  echo "<img src =\" " . $row['s3rawurl'] . "\" />";

    //echo "<img src =\"" .$row['s3finishedurl'] . "\"/>";#Finished URL not set
  //  echo "<p>".$row['id'] . "Email: " . $row['email']."</p>";
}

echo "</div>";

$link->close();
//include 'footer.php';
?>
	</body>
</html>
