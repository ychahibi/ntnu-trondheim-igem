# How to install iGEM Matchmaker

- Install a Apache, PHP (5.x), MySQL environment
- Create a MySQL database “<DATABASE_NAME>" for user “<USERNAME>” and password “<PASSWORD>”
- In our example “matchmaker_db”, “matchmaker_user”, “matchmaker_password”
- Obtain the Matchmaker files by download or using Git 
- Download from: https://github.com/ychahibi/ntnu-trondheim-igem/archive/master.zip
$ git clone  https://github.com/ychahibi/ntnu-trondheim-igem.git
- Create the database structure in the command line

`$ mysql -u matchmaker_user -p < ntnu-trondheim-igem/igem_matchmaker/install/matchmaker_db.sql`
The file assumes the database name is “matchmaker_db"
- Copy the file ntnu-trondheim-igem/igem_matchmaker/install/mysql_connect_install.php to ntnu-trondheim-igem/igem_matchmaker/mysql_connect.php 

`$ cp ntnu-trondheim-igem/igem_matchmaker/install/mysql_connect_install.php ntnu-trondheim-igem/igem_matchmaker/mysql_connect.php
- Set the hostname, database, username and password for `the database

`$ perl -pi -e 's/<HOSTNAME>/localhost/' ntnu-trondheim-igem/igem_matchmaker/mysql_connect.php
$ perl -pi -e 's/<USERNAME>/matchmaker_user/' ntnu-trondheim-igem/igem_matchmaker/mysql_connect.php
$ perl -pi -e 's/<PASSWORD>/matchmaker_password/' ntnu-trondheim-igem/igem_matchmaker/mysql_connect.php
$ perl -pi -e 's/<DATABASE>/matchmaker_db/' ntnu-trondheim-igem/igem_matchmaker/mysql_connect.php`


# How to support a new year
- Edit URLs for the new year
- In file header.php, update the Community page link: 

`$ perl -pi -e 's/http:\/\/2015.igem.org\/Community/http:\/\/2016.igem.org\/Community/' ntnu-trondheim-igem/igem_matchmaker/header.php`
- In file score.php, update the template team page link: 

`$ perl -pi -e 's/http:\/\/2015.igem.org\/Team/http:\/\/2016.igem.org\/Team/' ntnu-trondheim-igem/igem_matchmaker/score.php`
-In file score.php, update the template team page link: 

`$ perl -pi -e 's/http:\/\/2015.igem.org\/Team/http:\/\/2016.igem.org\/Team/' ntnu-trondheim-igem/igem_matchmaker/sidebar.php`
- In file matchmaker.php, change the following paragraph

`			<li <?php echo 'class="' . ($_GET['year']==2015 || !isset($_GET['year']) ? 'active">' : '">');?>

				<a href="?year=2015">2015</a>

			</li>`
			
to the following

`			<li <?php echo 'class="' . ($_GET['year']==2016 || !isset($_GET['year']) ? 'active">' : '">');?>

				<a href="?year=2016">2016</a>

			</li>

			<li <?php echo 'class="' . ($_GET['year']==2015 ? 'active">' : '">');?>

				<a href="?year=2015">2015</a>

			</li>`
And this paragraph

`			} else {

				$result = mysql_query("SELECT * FROM 			mm_entries WHERE year=2015 ORDER BY time DESC");

			}`
			
to the following

`			} elseif ($_GET['year']==2015) {
				$result = mysql_query("SELECT * FROM mm_entries WHERE year=2015 ORDER BY time DESC");
			} else {
				result = mysql_query("SELECT * FROM mm_entries WHERE year=2016 ORDER BY time DESC");
			}`

# How to run the Matchmaker
- Install Java Developer kit and MAUI (https://code.google.com/archive/p/maui-indexer/wikis/Usage.wiki)
- Run the following commands to generate the JSON file

`$ python downloadAllTeamsInfos.py -y 2016 -o teamsInfo.pkl

$ python calculateKeywordWeights.py -i teamsInfo.pkl -o keywordsWeights.pkl -m MAUI/maui-standalone-1.1-SNAPSHOT.jar -e MAUI/data/models/keyword_extraction_model

$ python matchmaker.py -t teamsInfo.pkl -i keywordsWeights.pkl -o teamsMatchmaking_2016.json`
- Copy the teamsMatchmaking JSON file to the data directory of the website

`$ cp ntnu-trondheim-igem/igem_matchmaker/backend/teamsMatchmaking_2016.json ntnu-trondheim-igem/igem_matchmaker/data/`
- In the files header.php change the following line to the right file 

`$string = file_get_contents("data/teamsMatchmaking_2016.json”);`

