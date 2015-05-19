<?php

	include("mysql_connect.php");	

	$team = mysql_real_escape_string($_POST["team"]);
	$country = mysql_real_escape_string($_POST["country"]);
	$description = mysql_real_escape_string($_POST["description"]);
	$type = mysql_real_escape_string($_POST["type"]);
	$mail = mysql_real_escape_string($_POST["mail"]);

	$query = "INSERT INTO mm_collaborations (team, country, description, type, mail) VALUES ($team, $country, $description,$type, $mail)";
    $result = mysql_query($query) or die('Error inserting into database. Please try again or contact igem.ntnu@gmail.com.');

	include("mysql_close.php");
?>
