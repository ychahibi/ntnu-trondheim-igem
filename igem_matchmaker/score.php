
<?php include("header.php");?>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="extras/js/jqcloud.js"></script>
<link rel="stylesheet" href="extras/css/jqcloud.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript"  src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
?>

<div class="container">
	<?php	
	function getTeamInfo($json,$name) {
		$i=0;
		while (($i<count($json)) and ($json[$i]["name"]!=$name)) {
		    $i++;
		}
		$teamFound=($i < count($json));
		if (!$teamFound) {
			return NULL;
		} else {
			return $json[$i];
		}
	}
	
	function printTeamRanking($json,$teams,$style) {
		echo "<ol>";
		foreach ($teams as $key => $pair) {
			echo "<li>";
			echo "<a href=\"score.php?team=".$pair["name"]."\"><b>".str_replace("_"," ",$pair["name"])."</b></a>";
			echo " - ";
			echo "<i>".getTeamInfo($json,$pair["name"])["title"]."</i>";
			printf('<div class="progress">
			  <div class="progress-bar progress-bar-%s" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: %f%%">
			    %.2f%%
				<span class="sr-only">Complete (success)</span>
			  </div>
			</div>',$style,100*$pair["score"],100*$pair["score"]);
			echo "</li>";
			
		}
		echo "</ol>";
	}
	
	$string = file_get_contents("data/teamsMatchmaking_1442154848.16.json");
	$json = json_decode($string, true);
	
	if (!isset($_GET["team"])) {
		echo "";
	} else {
		$name=$_GET["team"];


		$teamInfo=getTeamInfo($json,$name);
		$teamFound=!is_null($teamInfo);
		if (!$teamFound) {
			echo "Team not found";
		} else {
		
		
			$team=$teamInfo;
			echo "<h1>Hello Team ".htmlspecialchars(str_replace("_"," ",$name))."!</h1>";
				
			// Keywords cloud
			echo "<p>Here is your project keyword cloud:</p>";
			echo '<div class="well">';
			echo '<center><h3>'.$team["title"].'</h3></center>';
			echo '<div id="keywords" style="width: 100%; height: 350px;"></div>';
			echo '
				<div class="btn-group btn-group-s" role="group">
				<a class="btn btn-default" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Abstract</a>
				<a class="btn btn-default" role="button" href="http://2015.igem.org/Team:'.$team["name"].'" aria-expanded="false" aria-controls="collapseExample">Website</a>
				<a class="btn btn-default" role="button" href="http://igem.org/Team.cgi?id='.$team["id"].'" aria-expanded="false" aria-controls="collapseExample">Team Information</a>
				
				</div>
				<div class="collapse" id="collapseExample">
				<br>
				<div class="well">
				<p>'.$team["abstract"].'</p>
				</div>
				</div>';
			
			echo '</div>';
		    echo "<script type=\"text/javascript\">";
			$keywords=json_encode(array_slice($team["keywords"],0,29));
			echo "$('#keywords').jQCloud(".$keywords.")";
			echo "</script>";
			echo "<p>We are using machine learning algorithms to analyze the project abstract and description of your project and those of other teams to find the most relevant teams to work with.</p>";
		

		
			echo '<div class="row">';
			echo '<div class="col-sm-6">';
			// Most helpful teams
			echo "<h2>Teams you can get help from:</h2>";
			printTeamRanking($json,$team["matchesMostHelpful"],"info");
			echo '</div>';
			echo '<div class="col-sm-6">';
			// Teams most in need
			echo "<h2>Teams you can help:</h2>";
			printTeamRanking($json,$team["matchesMostInNeed"],"alert");
			echo '</div>';
			echo '</div>';
			
		
		}
		
	}
	
	echo '
		<center><form action="matchmaker.php">
			<strong>Search:</strong>
			<select style="width: 50%" id="search-teams">
			<option value="default">Enter team name...</option>'
	;
	foreach ($json as $key => $team){
		var_dump($team["name"]);
		printf('<option value="%s">%s</option>',$team["name"],str_replace("_"," ",$team["name"]));
	};
	echo '
			</select>		
	  </form></center>
	<script type="text/javascript">
	$(\'#search-teams\').select2();
	$(\'#search-teams\').on("select2:select", function(e) { 
	   // what you would like to happen
	   window.location.href = "score.php?team="+$(\'#search-teams\').val();
	});
	</script>
	  ';
	
	?>
</div>	
<?php include("footer.php"); ?>
