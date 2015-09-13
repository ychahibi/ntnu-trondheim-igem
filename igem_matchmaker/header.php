<!DOCTYPE html>
<html lang="en"><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>iGEM Matchmaker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Google fonts -->    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,700italic,400italic" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <!--link href="https://bootswatch.com/united/bootstrap.min.css" rel="stylesheet">-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="custom.css">

</head>

<body>


<?php 

include("functions.php");

$error_msg_select = '<div class="alert alert-error fade in"--><a class="close" href="matchmaker.php">×</a>Error selecting from database. Please try again or contact igem.ntnu@gmail.com.';

$error_msg_insert = '<div class="alert alert-error fade in alert-warning alert-dismissable"><a class="close" href="matchmaker.php">×</a>Error inserting into database. Please try again or contact igem.ntnu@gmail.com.</div>';
?>
  
<!-- Navbar
================================================== -->
<div class="navbar navbar-static-top navbar-default">
	<div class="container">
	    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" style="font-family: 'Patua One', cursive; font-size: 24px; font-weight: Bold;" href="index.php">iGEM Matchmaker</a>
    </div>		  
	  <div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li <?php echo 'class="' . (basename($_SERVER['SCRIPT_FILENAME'])=='index.php'? 'active">' : '">');?>
				<a href="index.php">
				<?php echo '<i class="glyphicon glyphicon-home' . (basename($_SERVER['SCRIPT_FILENAME'])=='index.php'? ' icon-white">' : '">');?></i> Home</a>
			</li>
			<li <?php echo 'class="' . (basename($_SERVER['SCRIPT_FILENAME'])=='matchmaker.php'? 'active">' : '">');?>
				<a href="matchmaker.php">
				<?php echo '<i class="glyphicon glyphicon-heart' . (basename($_SERVER['SCRIPT_FILENAME'])=='matchmaker.php'? ' glyphicon-white">' : '">');?></i> Matchmaker</a>
			</li>
			<li class="divider-vertical"></li>
			<li>
				<a href="http://2015.igem.org/Community" target="_blank"><i class="glyphicon glyphicon-globe"></i>iGEM Community</a>
			</li>
		</ul>
		<form class="navbar-form navbar-right" method="get" action="matchmaker.php">
			<i class="glyphicon glyphicon-search"></i>
			<input type="text" name="q" class="input-medium search-query form-control" placeholder="Search for collaborations">
		
	  </form></div>
	</div>
  </div>
</div>
</body></html>