<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>iGEM Matchmaker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Google fonts -->    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,700italic,400italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
	
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
		body {
			padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}
		.sidebar-nav {
        	padding: 9px 0;
      	}
	</style>

</head>

<body>

<?php 

include("functions.php");

$error_msg_select = '<div class="alert alert-error fade in"><a class="close" href="matchmaker.php">&times;</a>Error selecting from database. Please try again or contact igem.ntnu@gmail.com.</div>';

$error_msg_insert = '<div class="alert alert-error fade in"><a class="close" href="matchmaker.php">&times;</a>Error inserting into database. Please try again or contact igem.ntnu@gmail.com.</div>';

?>
  
<!-- Navbar
================================================== -->
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container">
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </a>
	  <a class="brand" style="font-family: 'Permanent Marker'; font-size: 24px;" href="index.php">iGEM Matchmaker</a>
	  <!--<div class="btn-group pull-right">
          <a class="btn" href="#"><i class="icon-user"></i> User</a>
          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
            <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
            <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="i"></i> Make admin</a></li>
          </ul>
        </div>-->
	  <div class="nav-collapse">
		<ul class="nav">
			<li <?php echo 'class="' . (basename($_SERVER['SCRIPT_FILENAME'])=='index.php'? 'active">' : '">');?>
				<a href="index.php">
				<?php echo '<i class="icon-home' . (basename($_SERVER['SCRIPT_FILENAME'])=='index.php'? ' icon-white">' : '">');?></i> Home</a>
			</li>
			<li <?php echo 'class="' . (basename($_SERVER['SCRIPT_FILENAME'])=='matchmaker.php'? 'active">' : '">');?>
				<a href="matchmaker.php">
				<?php echo '<i class="icon-heart' . (basename($_SERVER['SCRIPT_FILENAME'])=='matchmaker.php'? ' icon-white">' : '">');?></i> Matchmaker</a>
			</li>
			<li class="divider-vertical"></li>
			<li>
				<a href="http://2015.igem.org/Community" target="_blank"><i class="icon-group"></i> iGEM Community</a>
		</ul>
		<form class="navbar-search pull-right" method="get" action="matchmaker.php" style="margin-right:0px;">
			<i class="icon-search"></i>
			<input type="text" name="q" class="input-medium search-query" placeholder="Search for collaborations">
		</form>
	  </div>
	</div>
  </div>
</div>

<div class="container">
	<div class="row-fluid">
