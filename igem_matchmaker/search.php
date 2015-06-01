<?php
  $var = @$_GET['q'];
  $trimmed = trim($var); //trim whitespace from the stored variable

// rows to return
$limit = 10; 

include("mysql_connect.php");

$countrified = array_search(strtoupper($trimmed), $countries);

// Build SQL Query  
$query = "SELECT * FROM mm_entries WHERE description LIKE '%$trimmed%' OR team LIKE '%$trimmed%' OR mail LIKE '%$trimmed%' OR type LIKE '%$trimmed%' OR country = '$countrified' ORDER BY time DESC";

$numresults = mysql_query($query);
$numrows = mysql_num_rows($numresults);

if ($numrows == 0) { ?>
	<div class="alert alert-error fade in">
		<a class="close" href="igem_matchmaker/matchmaker.php">&times;</a>
        <?php echo "Sorry, your search for &quot;" . $trimmed . "&quot; did not return any results." ?>
    </div>
<?php } else {

// next determine if s has been passed to script, if not use 0
  if (empty($s)) {
  	$s = 0;
  }

// get results
  $query .= " limit $s,$limit";
  $result = mysql_query($query) or die("Couldn't execute query");

// display what the person searched for
if ($trimmed != "") { ?>

<div class="alert alert-info fade in">
	<a class="close" href="igem_matchmaker/matchmaker.php">&times;</a>
	<strong><?php echo "You searched for &quot;" . $var . "&quot.<br/>"; ?></strong>
	<?php
		$a = $s + ($limit);
		if ($a > $numrows) { $a = $numrows ; }
		$b = $s + 1 ;
		echo "Showing results $b to $a of $numrows.";
	?>
</div>

<?php }

// begin to show results set

$count = 1 + $s ;

// now you can display the results returned

include("print_table.php");

$currPage = (($s/$limit) + 1);

  // next we need to do the links to other results
  if ($s>=1) { // bypass PREV link if s is 0
  $prevs=($s-$limit);
  print "&nbsp;<a href=\"$PHP_SELF?s=$prevs&q=$var\">&lt;&lt; 
  Prev 10</a>&nbsp&nbsp;";
  }

// calculate number of pages needing links
  $pages=intval($numrows/$limit);

// $pages now contains int of pages needed unless there is a remainder from division

  if ($numrows%$limit) {
  // has remainder so add one page
  $pages++;
  }

// check to see if last page
  if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {

  // not last page so give NEXT link
  $news=$s+$limit;

  echo "&nbsp;<a href=\"$PHP_SELF?s=$news&q=$var\">Next 10 &gt;&gt;</a>";
  }

}

?>
