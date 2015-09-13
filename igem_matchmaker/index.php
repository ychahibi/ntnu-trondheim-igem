<?php include("header.php") ?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript"  src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<?php
	$string = file_get_contents("data/teamsMatchmaking_1442154848.16.json");
	$json = json_decode($string, true);
?>
<div class="container">
	<div class="col-md-8">
			<div class="jumbotron">
				<div class="page-header">
					<h1>Hello, iGEM teams!</h1>
				</div>
				<p>Are you looking for another team to cooperate with? Then you are in the right place. Try the Matchmaker and find other teams to help or be helped by!</p><br/>
				
				<?php
						echo '
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
						</script>
						';
				?>
				or 
				<a class="btn btn-default btn-primary btn-lg" href="matchmaker.php">Create a post &raquo;</a>

			</div>
	</div>
	<div class="col-md-4">
			<h2 style="font-family: 'Patua One';"><i class="glyphicon glyphicon-pencil"></i>Changelog</h2>
		
	 		<?php include ("mysql_connect.php");
				$result = mysql_query("SELECT * FROM mm_news ORDER BY time DESC") or die('Error selecting from database. Please try again or contact igem.ntnu@gmail.com.');
				while($row = mysql_fetch_array($result)) {

					$heading = $row["heading"];
					$text = $row["text"];
					$author = $row["author"];
					$twitter_user = $row["twitter_user"];
					$time = $row["time"];
				
					$split = explode(" ", $time);
					$date = $split[0];

					?>
					<div class="well well-sm" style="margin-bottom: 5px;">
						<h3><?php echo $heading; ?></h3>
						<?php echo nl2br($text);?>
					</div>
					<?php echo '<div class="pull-right" ><i>Posted by <a href="http://twitter.com/' . $twitter_user . '">' . $author . '</a> on ' . str_replace("-", ".", $date) . '</i></div><br/><br/>';
				} ?>

	</div>
</div>
<?php include("footer.php"); ?>
