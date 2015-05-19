<?php
	$con = mysql_connect("insert_mysql_server_here","insert_username_here","insert_password_here");
	if (!$con)
	  {
	   die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("insert_database_name_here", $con);
?>
