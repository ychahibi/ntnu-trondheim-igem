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
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
		body {
			padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}
		.sidebar-nav {
        	padding: 9px 0;
      	}
	</style>
	<!-- Responsive css must be added after top padding -->
    <link href="bootstrap/css/responsive.css" rel="stylesheet">
    <link href="extras/css/extras.css" rel="stylesheet">
	
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <!--<link rel="shortcut icon" href="img/icons/oyas-icon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/icons/oyas-icon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/icons/oyas-icon-72.png">
    <link rel="apple-touch-icon-precomposed" href="img/icons/oyas-icon-57.png">-->

</head>

<body>

<?php 

include("functions.php");

$error_msg_select = '<div class="alert alert-error fade in"><a class="close" href="http://folk.ntnu.no/oyas/igem/igem_matchmaker/matchmaker.php">&times;</a>Error selecting from database. Please try again or contact igem.ntnu@gmail.com.</div>';

$error_msg_insert = '<div class="alert alert-error fade in"><a class="close" href="http://folk.ntnu.no/oyas/igem/igem_matchmaker/matchmaker.php">&times;</a>Error inserting into database. Please try again or contact igem.ntnu@gmail.com.</div>';

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
	  <a class="brand" style="font-family: 'Permanent Marker'; font-size: 24px;" href="/oyas/igem/igem_matchmaker/">iGEM Matchmaker</a>
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
				<a href="/oyas/igem/igem_matchmaker/">
				<?php echo '<i class="icon-home' . (basename($_SERVER['SCRIPT_FILENAME'])=='index.php'? ' icon-white">' : '">');?></i> Home</a>
			</li>
			<li <?php echo 'class="' . (basename($_SERVER['SCRIPT_FILENAME'])=='matchmaker.php'? 'active">' : '">');?>
				<a href="matchmaker.php">
				<?php echo '<i class="icon-heart' . (basename($_SERVER['SCRIPT_FILENAME'])=='matchmaker.php'? ' icon-white">' : '">');?></i> Matchmaker</a>
			</li>
			<li class="divider-vertical"></li>
			<li>
				<a href="http://2014.igem.org/Community" target="_blank"><i class="icon-group"></i> iGEM Community</a>
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