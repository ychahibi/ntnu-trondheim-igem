<div class="span2">
	<div class="well sidebar-nav control-panel visible-desktop">
		<ul class="nav nav-list">
			<li class="nav-header">Control panel</li>
		    <li class=""><a data-toggle="modal" href="#newEntry"><i class="icon-plus-sign"></i>New entry</a></li>
		    <li class=""><a data-toggle="modal" href="?edit=1"><i class="icon-edit"></i>Edit entry</a></li>
		</ul>
	</div><!--/.well -->
	<!--<div class="alert alert-info">
		Showing all entries.
	</div>-->
</div><!--/span-->

<div class="span2 hidden-desktop">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			<li class="nav-header">Control panel</li>
		    <li class=""><a data-toggle="modal" href="#newEntry"><i class="icon-plus-sign"></i>New entry</a></li>
		    <li class=""><a data-toggle="modal" href="?edit=1"><i class="icon-edit"></i>Edit entry</a></li>
		</ul>
	</div><!--/.well -->
	<!--<div class="alert alert-info">
		Showing all entries.
	</div>-->
</div><!--/span-->

<div id="newEntry" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>New entry</h3>
    </div>
	<form class="form-horizontal" action="#" method="post">
		<div class="modal-body">
			<fieldset>
				<div class="control-group">
		        	<label class="control-label" for="teamName">Team name</label>
		        	<div class="controls">
		          		<input type="text" class="input-xlarge" id="teamName" name="team">
		          		<p class="help-block">Enter your team name as it appears after "Team:" in the URL of your wiki home page. E.g., if your wiki URL is http://2012.igem.org/Team:NTNU_Trondheim, write "NTNU_Trondheim".</p>
		        	</div>
		      	</div>
		      	<div class="control-group">
		        	<label class="control-label" for="countrySelect">Country</label>
		        	<div class="controls">
	 					<select id="countrySelect" name="country">
							<?php include("countries.html"); ?>
						</select>
		        	</div>
		      	</div>
		     	<div class="control-group">
		        	<label class="control-label" for="description">Description of collaboration</label>
		        	<div class="controls">
		          		<textarea class="input-xlarge" id="description" rows="4" name="description"></textarea>
						<p class="help-block">You may format your text using HTML. URLs are automatically detected and made clickable.</p>
		        	</div>
		      	</div>
		      	<div class="control-group">
		        	<label class="control-label">Collaboration type</label>
		        	<div class="controls">
		          		<label class="radio">
		            		<input type="radio" name="type" id="typeRadio1" value="offer" checked>Offer
		         	 	</label>
		          		<label class="radio">
		            		<input type="radio" name="type" id="typeRadio2" value="request">Request
		          		</label>
						<label class="radio">
		            		<input type="radio" name="type" id="typeRadio3" value="other">Other
		          		</label>
						<p class="help-block">Choose "Offer" if you want to help and "Request" if you want to be helped.</p>
		        	</div>
				</div>
		     	<div class="control-group">
		        	<label class="control-label" for="status">Status</label>
					<div class="controls">
						<!--<div class="btn-group">
							<button type="button" class="btn btn-on active">Open</button>
							<button type="button" class="btn btn-off">Closed</button>
						</div>
						<input type="hidden" name="status" value="open" />-->
						<label class="radio">
		            		<input type="radio" name="status" id="statusRadio1" value="open" checked >Open
		         	 	</label>
		          		<label class="radio">
		            		<input type="radio" name="status" id="statusRadio2" value="closed" disabled >Closed
		          		</label>

		          		<p class="help-block">All new entries must initially be open. You can close it later at any time.</p>
					</div>
				</div>
				<div class="control-group">
		        	<label class="control-label" for="mail">E-mail</label>
		        	<div class="controls">
		          		<input type="text" class="input-xlarge" id="mail" name="mail">
		          		<p class="help-block">This e-mail address will be posted as contact information for this entry in the Matchmaker. Please use a valid address.</p>
		        	</div>
		      	</div>
		 	</fieldset>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary" name="new-entry">Create entry</button>
		    <a class="btn" data-dismiss="modal" href="#">Cancel</a>
		</div>
	</form>
</div>



<div id="editEntry" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Edit entry</h3>
    </div>

<?php
	include("mysql_connect.php");
	$editID = $_GET['id'];
	$result = mysql_query("SELECT * FROM mm_entries WHERE id = '$editID'");
	$id = $row["id"];

	while($row = mysql_fetch_array($result)) {
		$type = $row["type"];
		$team = $row["team"];
		$country = $row["country"];
		$mail = $row["mail"];
		$description = $row['description'];
		$time = $row["time"];
		$status = $row["status"];
	?>
	<form class="form-horizontal" action="#" method="post">
		<input type="hidden" name="id" value="<?php echo $editID; ?>" />
		<div class="modal-body">
			<fieldset>
				<div class="control-group">
		        	<label class="control-label" for="teamName">Team name</label>
		        	<div class="controls">
		          		<input type="text" class="input-xlarge" id="teamName" name="team" <?php echo 'value="' . $team . '"';?>>
		          		<p class="help-block">Enter your team name as it appears after "Team:" in the URL of your wiki home page. E.g., if your wiki URL is http://2012.igem.org/Team:NTNU_Trondheim, write "NTNU_Trondheim".</p>
		        	</div>
		      	</div>
		      	<div class="control-group"> 
		        	<label class="control-label" for="countrySelect">Country</label>
		        	<div class="controls">
	 					<select id="countrySelect" name="country">
							<?php echo dropdown($countries, $country);?>
						</select>
		        	</div>
		      	</div>
		     	<div class="control-group">
		        	<label class="control-label" for="description">Description of collaboration</label>
		        	<div class="controls">
		          		<textarea class="input-xlarge" id="description" rows="4" name="description" ><?php echo $description;?></textarea>
						<p class="help-block">You may format your text using HTML. URLs are automatically detected and made clickable.</p>
		        	</div>
		      	</div>
		      	<div class="control-group">
		        	<label class="control-label">Collaboration type</label>
		        	<div class="controls">
		          		<label class="radio">
		            		<input type="radio" name="type" id="typeRadio1" value="offer" <?php if ($type == 'offer') {echo 'checked';}?> >Offer
		         	 	</label>
		          		<label class="radio">
		            		<input type="radio" name="type" id="typeRadio2" value="request" <?php if ($type == 'request') {echo 'checked';}?>>Request
		          		</label>
						<label class="radio">
		            		<input type="radio" name="type" id="typeRadio3" value="other"<?php if ($type == 'other') {echo 'checked';}?>>Other
		          		</label>
						<p class="help-block">Choose "Offer" if you want to help and "Request" if you want to be helped.</p>
		        	</div>
				</div>
		     	<div class="control-group">
		        	<label class="control-label" for="status">Status</label>
					<div class="controls">
						    <!--<div class="btn-group" data-toggle-name="status" data-toggle="buttons-radio">
								<button type="button" class="btn btn-on <?php if ($status == 'open' || empty($status)) {echo 'active';}?>" value="open" data-toggle="button" id="statusRadio1">Open</button>
								<button type="button" class="btn btn-off <?php if ($status == 'closed') {echo 'active';}?>" value="closed" data-toggle="button" id="statusRadio2">Closed</button>
							</div>
						<input type="hidden" name="status" value="open" />-->
						<label class="radio">
		            		<input type="radio" name="status" id="statusRadio1" value="open" <?php if ($status == 'open' || empty($status) ) {echo 'checked';}?> >Open
		         	 	</label>
		          		<label class="radio">
		            		<input type="radio" name="status" id="statusRadio2" value="closed" <?php if ($status == 'closed') {echo 'checked';}?> >Closed
		          		</label>
		          		<p class="help-block">If you still want to find other teams to collaborate with, choose "Open". "Closed" means that you no longer want to be contacted regarding this entry.</p>
					</div>
				</div>
				<div class="control-group">
		        	<label class="control-label" for="mail">E-mail</label>
		        	<div class="controls">
		          		<input type="text" class="input-xlarge" id="mail" name="mail" value="<?php echo $mail;?>">
		          		<p class="help-block">This e-mail address will be posted as contact information for this entry in the Matchmaker. Please use a valid address.</p>
		        	</div>
		      	</div>
		 	</fieldset>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary" name="update-entry">Update entry</button>
		    <a class="btn" data-dismiss="modal" href="#">Cancel</a>
		</div>
	</form>
<?php } ?>
</div>
