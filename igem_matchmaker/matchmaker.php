<?php include("header.php") ?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript"  src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<?php
	$string = file_get_contents("data/teamsMatchmaking_1442154848.16.json");
	$json = json_decode($string, true);
?>

<div class="container">

	
	<?php include("sidebar.php"); ?>
	<div class="col-md-10">

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
			<div class="jumbotron" style="border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;">
		        <div class="container-fluid">
				    <h1>Waiting for this year's first entry...</h1><br/>
				    <p></p><br/>
				    <p>
					    <a class="btn btn-primary btn-large" data-toggle="modal" href="#newEntry">
					    	<i class="glyphicon glyphicon-plus-sign"></i> Click here to be the first!
					    </a>
				    </p>
			    </div>
			</div>
			<?php
		} else {
			include("print_table.php");
		}	
		
		echo "<p>Have you not found any team to collaborate with in this list? Enter your team name here and we will use machine learning algorithms to find the best teams to contact:</p>";
		
		echo '
			<center>
			<select style="width: 50%" id="search-teams">
			<option value="default">Enter team name...</option>'
		;
		foreach ($json as $key => $team){
		var_dump($team["name"]);
		printf('<option value="%s">%s</option>',$team["name"],str_replace("_"," ",$team["name"]));
		};
		echo '
			</select>
		
		<script type="text/javascript">
		$(\'#search-teams\').select2();
		$(\'#search-teams\').on("select2:select", function(e) { 
		// what you would like to happen
		window.location.href = "score.php?team="+$(\'#search-teams\').val();
		});
		</script></center>
		';
	}

	?>
	</div>
</div>	
<?php include("footer.php"); ?>
