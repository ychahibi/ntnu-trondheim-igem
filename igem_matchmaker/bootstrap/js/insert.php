<?php
// Check for posted collaboration
if(isset($_POST['new-collaboration'])) {
	
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

		$team = $_POST["team"];
		$country = $_POST["country"];
		$description = $_POST["description"];
		$type = $_POST["type"];
		$mail = $_POST["mail"];
	
		$result = mysql_query("SELECT * FROM mm_collaborations WHERE team ='$team' AND description='$description'") or die('Error selecting from database. Please try again or contact igem.ntnu@gmail.com.');
		$count = mysql_num_rows($result);

		// If no matching entries are found, insert into database
		if ($count == 0) {
			$query = "INSERT INTO mm_collaborations (team, country, description, type, mail) VALUES ('$team', '$country', '$description','$type', '$mail')";
			$result = mysql_query($query) or die('Error inserting into database. Please try again or contact igem.ntnu@gmail.com.');

		}
		// If matching entries are found, display error message		
		else { ?>
			<div class="alert alert-error fade in">
		        <button type="button" class="close" data-dismiss="alert">&times;</button>
		        <strong>Error!</strong> An identical entry already exists. If you want to edit or remove an existing entry, please contact the NTNU Trondheim iGEM team at <a href="mailto:igem.ntnu@gmail.com">igem.ntnu@gmail.com</a>.
		    </div><?php
		}
		// Disconnect
		include("mysql_close.php");
	}
}
?>
