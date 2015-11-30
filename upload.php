<?php
session_start();
include 'header.php';
?>
</p></p>
<form enctype="multipart/form-data" action="result.php" method="POST">
	<div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="userfile">Select file to Upload</label>
			</div>
			<div class="small-9 columns">
				<input type="file" id="userfile" name="userfile" placeholder="Choose File" />
			</div>
		</div>	
	</div>
	<div class="row">
        <div class="small-3 columns">
            <input class="button tiny" type="submit" value="Upload File" />
        </div>
    </div>
</form>
<?php
include 'footer.php';
?>