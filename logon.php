<?php
include 'header.php';

echo "</p> Included a header and a footer</p>";
?>
<form enctype="multipart/form-data" action="createsession.php" method="POST">
   
Enter Email of user: <input type="email" name="useremail"><br />
Enter Phone of user (1-XXX-XXX-XXXX): <input type="phone" name="phone">


<input type="submit" value="Send File" />
</form>
<?php
include 'footer.php';
?>