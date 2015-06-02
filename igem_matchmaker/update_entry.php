<?php
// Check for updated entry
if(isset($_POST['update-entry'])) {
	
	$required = array('team', 'description', 'type', 'mail');
	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	
	// Check that no fields are empty
	foreach($required as $field) {
	 	if (empty($_POST[$field])) {
			$error = true;
			echo $_POST[$field];
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

		$id = mysql_real_escape_string($_POST["id"]);
		$status = mysql_real_escape_string($_POST["status"]);
		$team = mysql_real_escape_string($_POST["team"]);
		$country = mysql_real_escape_string($_POST["country"]);
		$description = mysql_real_escape_string($_POST["description"]);
		$type = mysql_real_escape_string($_POST["type"]);
		$mail = mysql_real_escape_string($_POST["mail"]);
		$time = mysql_real_escape_string($_POST["time"]);
		
		// Random confirmation code
		$confirm_code=md5(uniqid(rand())); 
	
		$result = mysql_query("SELECT * FROM mm_temp WHERE id='$id'") or die('Error selecting from database. Please try again or contact igem.ntnu@gmail.com.');
		$count = mysql_num_rows($result);

		// If no matching entries are found, insert into database
		if ($count == 0) {
			$query = "INSERT INTO mm_temp (id, team, country, description, type, mail, status, confirm_code) VALUES ('$id', '$team', '$country', '$description','$type', '$mail', '$status', '$confirm_code')";
			$result = mysql_query($query) or die($error_msg_insert);

		}
		// If matching entries are found, update existing entry	
		else {
			$query = "UPDATE mm_temp SET status='$status', team='$team', country='$country', description='$description', type='$type', mail='$mail', confirm_code='$confirm_code', time='$time' WHERE id='$id'";
			$result = mysql_query($query) or die($error_msg_insert);

		}
		$result = mysql_query("SELECT * FROM mm_entries WHERE id='$id'") or die($error_msg_select);
		while($row = mysql_fetch_array($result)) {
			$old_mail = $row['mail'];
			$old_team = $row['team'];
		}
		// Disconnect
		include("mysql_close.php");
		
		$time = date("Y.m.d.");
		// Send e-mail with confirmation link

		$to = $old_mail;
		$subject = "[iGEM Matchmaker] Confirm update of your entry";
		$message = "
Hello, " . $old_team . "!

You are receiving this messsage because one of your entries in the iGEM Matchmaker has been edited. Your entry was edited on " . $time . " and the following information was provided:
		
	Team name: " . $team . "\n\n" .
"	Country: " . country_code_to_country($country) . "\n\n" .
"	Description: " . $description . "\n\n" .
"	Type: " . ucfirst($type) . "\n\n" .
"	Status: " . ucfirst($status) . "\n\n" .
"	E-mail: " . $mail . "

If this looks correct, please confirm the update of your entry by clicking the link below:\n
matchmaker.php?confirm_code=" . $confirm_code . "

Thank you for using the iGEM Matchmaker!
";
		$from = "iGEM Matchmaker";
		$headers = "From:" . $from;
		mail($to,$subject,$message,$headers);
		?>		
		<div class="alert alert-warning fade in">
			<a class="close" href="matchmaker.php">&times;</a>
    		<strong>Waiting for confirmation</strong><br/> Your changes have been registered and a confirmation e-mail has been sent to <?php echo $mail;?>. Please click the link provided in the e-mail to confirm the update of your entry.
		</div>
		<?php
	}
}

// If a confirmation code is set, check for matching updates
if(isset($_GET['confirm_code'])) {
	
	$confirm_code = $_GET['confirm_code'];
	$result = mysql_query("SELECT * FROM mm_temp WHERE confirm_code='$confirm_code'") or die('Error selecting from database. Please try again or contact igem.ntnu@gmail.com.');
	$count = mysql_num_rows($result);

	// If a matching update is found, insert into database and display confirmation message
	if ($count) {

		while($row = mysql_fetch_array($result)) {
			
			$id = mysql_real_escape_string($row["id"]);
			$status = $row["status"];
			$team = $row["team"];
			$country = $row["country"];
			$description = mysql_real_escape_string($row["description"]);
			$type = $row["type"];
			$mail = $row["mail"];

		}

		$query = "UPDATE mm_entries SET status='$status', team='$team', country='$country', description='$description', type='$type', mail='$mail' WHERE id='$id'";
		$result = mysql_query($query) or die($error_msg_insert);
		$query = "DELETE FROM mm_temp WHERE id='$id'";
		$result = mysql_query($query) or die('Error deleting from database. Please try again or contact igem.ntnu@gmail.com.');
		
		?>
		<div class="alert alert-success fade in">
        	<a class="close" href="matchmaker.php">&times;</a>
	        <strong>Entry updated</strong><br/> Your entry has been successfully updated!
	    </div><?php

	}
	// If no matching entries are found, display error message	
	else { ?>
		<div class="alert alert-error fade in">
        	<a class="close" href="matchmaker.php">&times;</a>
	        <strong>Invalid or outdated confirmation code</strong><br/> No matches for your confirmation code were found. The confirmation code may may be invalid or outdated. Please try editing your entry again.
	    </div><?php
	}
}
?>
