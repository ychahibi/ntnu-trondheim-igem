<?php
if ($_GET['edit']==1 && !isset($_POST['update-entry'])) {?>
	<div class="alert alert-info fade in">
		<a class="close" href="?edit=0">&times;</a>
    	<strong>Edit mode</strong><br/> Click the row you want to edit.
	</div>
<?php }

// Check for new entry
if(isset($_POST['new-entry'])) {
	
	$required = array('team', 'country', 'description', 'type', 'mail');
	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	
	// Check that no fields are empty
	foreach($required as $field) {
	 	if (empty($_POST[$field])) {
			$error = true;
	  	}
	}

	// If empty fields are found, display error message
	if ($error) { ?>
		<div class="alert alert-error fade in">
    		<button type="button" class="close" data-dismiss="alert">&times;</button>
        	<strong>Error!</strong> All fields are required. Please try again.
    	</div><?php
	}
	// If no fields are empty, connect to database
	else {
		include("mysql_connect.php");

		$team = mysql_real_escape_string($_POST["team"]);
		$country = mysql_real_escape_string($_POST["country"]);
		$description = mysql_real_escape_string($_POST["description"]);
		$type = mysql_real_escape_string($_POST["type"]);
		$mail = mysql_real_escape_string($_POST["mail"]);
	
		$result = mysql_query("SELECT * FROM mm_entries WHERE team ='$team' AND description='$description'") or die($error_msg_select);
		$count = mysql_num_rows($result);

		// If no matching entries are found, insert into database
		if ($count == 0) {

			$query = "INSERT INTO mm_entries (team, country, description, type, mail) VALUES ('$team', '$country', '$description','$type', '$mail')";
			$result = mysql_query($query) or die($error_msg_insert);
				
			?>
			<div class="alert alert-success fade in">
		        <button type="button" class="close" data-dismiss="alert">&times;</button>
		        <strong>Entry added</strong><br/> Your entry was successfully added to the Matchmaker. Now other iGEM teams can easily contact you with collaboration offers and requests.<br/> If you wish to edit your entry, click "Edit entry" in the control panel to the left.
		    </div><?php

		}
		// If matching entries are found, display error message		
		else { ?>
			<div class="alert alert-error fade in">
		        <button type="button" class="close" data-dismiss="alert">&times;</button>
		        <strong>Error!</strong><br/> An identical entry already exists. If you want to edit or remove an existing entry, please contact the NTNU Trondheim iGEM team at <a href="mailto:igem.ntnu@gmail.com">igem.ntnu@gmail.com</a>.
		    </div><?php
		}
		// Disconnect
		include("mysql_close.php");
	}
}
?>
