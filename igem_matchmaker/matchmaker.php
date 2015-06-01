<?php include("header.php"); ?>
<?php include("sidebar.php"); ?>

<div class="span10">

<?php

// New entries
include("new_entry.php");

// Update entries
include("update_entry.php");

?>

<?php

// If a search query is set, display matching entries
if(isset($_GET['q'])) {
	include('search.php');
}
// If no search query is set, display all entries
else {
	?>
	<!-- Nav for separating entries by year -->
	<ul class="nav nav-tabs" id="year-nav">
		<li class="disabled"></li>
		<li <?php echo 'class="' . ($_GET['year']==2015 || !isset($_GET['year']) ? 'active">' : '">');?>
			<a href="?year=2015">2015</a>
		</li>
		<li <?php echo 'class="' . ($_GET['year']==2014 ? 'active">' : '">');?>
			<a href="?year=2014">2014</a>
		</li>
		<li <?php echo 'class="' . ($_GET['year']==2013 ? 'active">' : '">');?>
			<a href="?year=2013">2013</a>
		</li>
		<li <?php echo 'class="' . ($_GET['year']==2012 ? 'active">' : '">');?>
			<a href="?year=2012">2012</a>
		</li>
	</ul>
	<?php
	include("mysql_connect.php");
	// Sorting by year
	if ($_GET['year']==2012) {
		$result = mysql_query("SELECT * FROM mm_entries WHERE year=2012 ORDER BY time DESC");
	} elseif ($_GET['year']==2013) {
		$result = mysql_query("SELECT * FROM mm_entries WHERE year=2013 ORDER BY time DESC");
	} elseif ($_GET['year']==2014) {
		$result = mysql_query("SELECT * FROM mm_entries WHERE year=2014 ORDER BY time DESC");
	} else {
		$result = mysql_query("SELECT * FROM mm_entries WHERE year=2015 ORDER BY time DESC");
	}
    if (!mysql_num_rows($result)) {
		?>
        <div class="hero-unit">
		    <h1>Waiting for this year's first entry...</h1><br/>
		    <p></p><br/>
		    <p>
			    <a class="btn btn-primary btn-large" data-toggle="modal" href="#newEntry">
			    	<i class="icon-plus-sign"></i> Click here to be the first!
			    </a>
		    </p>
	    </div>
		<?php
	} else {
		include("print_table.php");
	}	
}

?>
</div>
<?php include("footer.php"); ?>
