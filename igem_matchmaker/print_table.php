<table class="table collaboration-table sortable" <?php if ($_GET['edit'] && !isset($_POST['update-entry'])) {echo 'id="clickable"';}?>>
	<thead>
		<tr>
			<th><a class="tooltip-up" href="#" rel="tooltip" title="Click to sort">Type</a></th>
			<th><a class="tooltip-up" href="#" rel="tooltip" title="Click to sort">Team</a></th>
			<th><a class="tooltip-up" href="#" rel="tooltip" title="Click to sort">Date added</a></th>
			<th class="sorttable_nosort">Description</th>
			<th><a class="tooltip-up" href="#" rel="tooltip" title="Click to sort">Status</a></th>
			<th class="sorttable_nosort"> </th>
		</tr>
	</thead>
	<tbody>
		<?php
		while($row = mysql_fetch_array($result)) {
			
			$id = $row["id"];
			$team = $row["team"];
			$country = $row["country"];
			$description = $row['description'];
			$type = $row["type"];
			$status = $row["status"];
			$mail = $row["mail"];
			$time = $row["time"];
			$year = $row["year"];

			// Regular expression filter for detecting URLs
			$reg_exUrl = "/((((http|https|ftp|ftps)\:\/\/)|www\.)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\/\S*)?)/";
			
			// Turn URLs into HTML links
			$description = preg_replace($reg_exUrl, "<a href=\"$1\" target='_blank'>$1</a>", $description);

			?>
			<tr>
				<td>
					<?php 
						$href = '?id=' . $id;
						echo '<a href="' . $href . '&edit=1"></a>';
						echo '<span class="label';
						if ($type == 'offer') {
							echo ' label-success">Offer';
						} elseif ($type == 'request') {
							echo ' label-warning">Request';
						} else {
							echo '">Other';
						}
					?>
					</span>
				</td>
				<td>
					<?php echo '<a class="tooltip-down" href="#" title="' . country_code_to_country($country) . '"><img class="flag" src="famfamfam_flag_icons/png/' . strtolower($country) . '.png" /></a>';?>
					<?php echo '<a href="http://'. $year . '.igem.org/Team:' . $team . '"'; ?> target="_blank"><?php echo $team;?></a>
				</td>
				<td class="date-cell">
					<?php
						$split = explode(" ", $time);
						$date = $split[0];
						echo str_replace("-", ".", $date);
					?>
				</td>
				<td class="description-cell"><?php echo nl2br($description);?></td>
				<td style="text-align:center;">
					<?php
					echo '<a class="tooltip-up" href="#" title="';
						if ($status == 'closed') {
							echo 'This team is alreading being helped by another team." style="color: #9d261d;">Closed</a>';
						} else {
							echo 'Contact to start collaborating!" style="color: #46a546">Open</a>';
						}
					?>
					</span>
				</td>				
				<td style="text-align: center;"><?php echo '<a href="mailto:' . $mail . '">';?><button class="btn btn-primary" <?php if ($status == 'closed') {echo 'disabled="disabled"';} ?> >Contact</button></a></td>
				<!--<td><a class="tooltip-right" href="#" rel="tooltip" title="Click to edit"><i class="icon-edit"></i></a></td>-->
			</tr>
		<?php }
			include ("mysql_close.php");
		?>
	</tbody>
</table>
