<?php
	$con = mysql_connect("localhost","igem_matchmaker","iGEM2015!");
	if (!$con)
	  {
	   die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("igem_db", $con);
?>
