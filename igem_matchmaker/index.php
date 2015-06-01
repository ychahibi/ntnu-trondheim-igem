<?php include("header.php") ?>
<div class="span8">
	<div class="hero-unit">
		<h1>Hello, iGEM teams!</h1><br/>
		<p>Are you looking for another team to cooperate with? Then you are in the right place. Try the Matchmaker and find other teams to help or be helped by!</p><br/>
		<p><a class="btn btn-primary btn-large" href="matchmaker.php"">Begin cooperating &raquo;</a></p>
	</div>
</div>
<div class="span4">
		<h2 style="font-family: 'Permanent Marker';"><i class="icon-pencil"></i> Changelog</h2>
		
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
				<div class="well well-small" style="margin-bottom: 5px;">
					<h3><?php echo $heading; ?></h3>
					<?php echo nl2br($text);?>
				</div>
				<?php echo '<div class="pull-right" ><i>Posted by <a href="http://twitter.com/' . $twitter_user . '">' . $author . '</a> on ' . str_replace("-", ".", $date) . '</i></div><br/><br/>';
			} ?>


<!-- 		<div class="accordion" id="accordionHome">
		<?php include ("mysql_connect.php");
			$result = mysql_query("SELECT * FROM mm_news ORDER BY time DESC") or die('Error selecting from database. Please try again or contact igem.ntnu@gmail.com.');
			$acc_count = 1;
			while($row = mysql_fetch_array($result)) {

				$heading = $row["heading"];
				$text = $row["text"];
				$author = $row["author"];
				$twitter_user = $row["twitter_user"];
				$time = $row["time"];
				
				$split = explode(" ", $time);
				$date = $split[0];

				?>

				
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionHome" href="#collapse<?php echo $acc_count; ?>">
								<h4><?php echo $heading; ?></h4>
							</a>
						</div>
						<div id="collapse<?php echo $acc_count; ?>" class="accordion-body collapse <?php if ($acc_count == 1) {echo 'in';};?>">
							<div class="accordion-inner">
								<?php echo nl2br($text);?>
								<?php echo '<div class="pull-right" ><i>Posted by <a href="http://twitter.com/' . $twitter_user . '">' . $author . '</a> on ' . str_replace("-", ".", $date) . '</i></div><br/><br/>'; ?>
							</div>
						</div>
					</div>
					<?php $acc_count++; } ?>
		</div> -->
</div>

<?php include("footer.php"); ?>
