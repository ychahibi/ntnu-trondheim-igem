<?php
	$con = mysql_connect("<HOSTNAME>","<USERNAME>","<PASSWORD>");
	if (!$con)
	  {
	   die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("<DATABASE>", $con);
?>
