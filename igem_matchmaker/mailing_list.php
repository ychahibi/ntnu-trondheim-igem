<html>
<?php
include("mysql_connect.php");
$result = mysql_query("SELECT * FROM mm_entries") or die('Error selecting from database. Please try again or contact igem.ntnu@gmail.com.');
while($row = mysql_fetch_array($result)) {
	echo $row["mail"] . "<br/>";
}
include("mysql_close.php");
?>
</html>
