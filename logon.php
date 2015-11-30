<?php
include 'header.php';
?>
<form enctype="multipart/form-data" action="createsession.php" method="POST">
	<div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="username">User Id*</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="username" placeholder="Enter Your User Name" />
			</div>
		</div>	
	</div>
    <div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="useremail">Email*</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="useremail" placeholder="Enter Your Email Address" />
			</div>
		</div>
	</div>
    <div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="phone">Phone*</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="phone" placeholder="Enter Your Phone Number" />
			</div>
		</div>
    </div>
    <div class="row">
        <div class="large-4 columns">
            <input class="button" type="submit" value="Logon" />
        </div>
    </div>
<!--Enter Email of user: <input type="email" name="useremail"><br />
Enter Phone of user (1-XXX-XXX-XXXX): <input type="phone" name="phone">


<input type="submit" value="Logon" />-->
</form>
<?php
include 'footer.php';
?>