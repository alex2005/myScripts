<?php

include_once "titlemanager.php.inc";

function currentplaying ()
{
	$lines = file( "/tmp/meta.txt" ); 
	for( $i = 0; $i < sizeof($lines); $i++ ) 
	{ 	    
	    if ( $i == 0 ) { echo "<h3>Zur Zeit gespielt: "; }
	    if (preg_match("*Artist=*", $lines[$i]) ) 
	    { 
        	$str = ereg_replace( "Artist=", "", $lines[$i] ); 
        	#$str = $lines[$i]; 
        	echo "$str - "; 
	    } 
	    if (preg_match("*Title=*", $lines[$i]) ) 
	    { 
        	$str = ereg_replace( "Title=", "", $lines[$i] ); 
        	echo "$str\n"; 
	    } 
	}
	echo "</h3>";
}

function connecttodb ()
{
	//connect to your database ** EDIT REQUIRED HERE **
	mysql_connect("localhost","root","test"); //(host, username, password)

	//specify database ** EDIT REQUIRED HERE **
	mysql_select_db("musik") or die("Unable to select database"); //select which database we're using
}

function addtoq ($string)
{
	$class= new TitleManager();
	if ( $class->isTitlePresent($string) ) 
	{ 
		#echo "***TITEL vorhanden!<br />"; 
	}
	else
	{
		#echo "*** Added to Queue!";
		$class->enqueue($string);
		$class->save();
	}


}


function addrandom ()
{
	connecttodb();
	$query = "SELECT path FROM mp3 ORDER BY Rand() LIMIT 10"; // EDIT HERE and specify your table and field names for the SQL query
	$result = mysql_query($query) or die("Couldn't execute query");
	  while ($row= mysql_fetch_array($result)) {
	  $file = $row["path"];
	  #echo $file;
	  addtoq($file);
	  
	  }
	
}

## header mit javascript
?>
<html>
<head>
<script language="javascript">
function checkAll(){
	for (var i=0;i<document.forms[2].elements.length;i++)
	{
		var e=document.forms[2].elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox'))
		{
			e.checked=document.forms[2].allbox.checked;
		}
	}
}
</script>
</head>

<?
echo '<table border=0><tr><form><td width=125 align=center><input type="submit" name="action" value="Home"></td>';
echo '<td width=125 align=center><input type="submit" name="action" value="Loeschen"></td>';
echo '<td width=125 align=center><input type="submit" name="action" value="Ueberspringen"></td>';
echo '<td width=125 align=center><input type="submit" name="action" value="Queue Random"></td></form>';
echo '<form><td align=center><input type="text" name="q" value="Overkill">
	<input type="submit" name="suche" value="Suchen"></td></form>';

echo '</tr></table>';

#http://www.designplace.org/scripts.php?page=1&c_id=25 

if (isset($_POST['file'])) {
	$N = count($_POST['file']);
	for($i=0; $i < $N; $i++)
	    {
	      #echo($_POST['file'][$i] . "<br \>");
		addtoq(@$_POST['file'][$i]);
	    }
}

if (isset($_REQUEST['q'])) {

$s = @$_GET['s'] ;
$var = @$_GET['q'] ;
$trimmed = trim($var);

connecttodb();

// Build SQL Query  
$query = "SELECT * FROM mp3 WHERE path LIKE \"%$trimmed%\"  
  ORDER BY path"; // EDIT HERE and specify your table and field names for the SQL query

 $numresults=mysql_query($query);
 $numrows=mysql_num_rows($numresults);

if ($numrows == 0)
{
  echo "<h4>Results</h4>\n";
  echo "<p>Sorry, your search: &quot;" . $trimmed . "&quot; returned zero results</p>\n";
  echo "<a href=\"index.php\">HOME</a>\n";
  
  exit();
}
// rows to return
$limit=20; 
// next determine if s has been passed to script, if not use 0
  if (empty($s)) {
  $s=0;
  }

// get results
$query .= " limit $s,$limit";
$result = mysql_query($query) or die("Couldn't execute query");
// display what the person searched for
echo "<p>You searched for: &quot;" . $var . "&quot;</p>";

// begin to show results set
echo "<b>Results</b><br /><form action=\"".$_SERVER['SCRIPT_NAME']."?s=$s&q=$var\" method=\"post\">\n<table border=1>\n";
$count = 1 + $s ;

// now you can display the results returned
  while ($row= mysql_fetch_array($result)) {
  $title = $row["filename"];
  $file = $row["path"];

  echo "<tr><td>$title</td>" ;
  echo "<td><input type=\"checkbox\" value=\"$file\" name=\"file[]\"></form>";
  echo "</td></tr>\n" ;
 
  $count++ ;
  }
echo "</table>";
$currPage = (($s/$limit) + 1);

//break before paging
  echo "<br />";

  // next we need to do the links to other results
  if ($s>=1) { // bypass PREV link if s is 0
  $prevs=($s-$limit);
  print "&nbsp;<a href=\"".$_SERVER['SCRIPT_NAME']."?s=$prevs&q=$var\">&lt;&lt; 
  Prev $limit</a>&nbsp&nbsp;\n";
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

  echo "&nbsp;<a href=\"".$_SERVER['SCRIPT_NAME']."?s=$news&q=$var\">Next $limit &gt;&gt;</a>\n";
  }

$a = $s + ($limit) ;
  if ($a > $numrows) { $a = $numrows ; }
  $b = $s + 1 ;
  echo "<p>Showing results $b to $a of $numrows</p>";
 
echo "<input type=\"submit\" value=\"Add to Queue\"><input type=\"checkbox\" value=\"on\" name=\"allbox\" onclick=\"checkAll();\"/> Check all<br /></form><hr />\n";
 
//exit();

} 
#### 


if (isset($_REQUEST['action'])) {
	if ($_REQUEST['action'] == "Ueberspringen") {
		echo "<h3>&Uuml;bersprungen!</h3>";
		system('kill `pgrep sox`'); # must run as www-data
	}
	if ($_REQUEST['action'] == "Loeschen") {
		echo "<h3>Einer gel&ouml;scht!</h3>";
		$class= new TitleManager();
		$class->dequeue();
		$class->save();
	}
	if ($_REQUEST['action'] == "Queue Random") {
		echo "<h3>Zufallslieder zu Queue hinzugef&uuml;gt!</h3>";
		addrandom();
	}
	if ($_REQUEST['action'] == "Home") {
		#echo"<br />";
		currentplaying();
	}
}
#else
#{
#	echo "<br />";
#}

echo "<h2>** Current Queue</h2>";
$class= new TitleManager();
$class->printValues();


?></html><?

exit();

#TitleManager::loadTitles();


exit();

$class= new TitleManager();

$class->enqueue("test1");
$class->enqueue(test2);
$class->enqueue(test3);

echo "#######<br />";
$class->printValues();

if ( $class->isTitlePresent(test1) ) { echo "***TITEL vorhanden!<br />"; }

echo "#######<br />";
$class->printValues();

if ( !$class->isTitlePresent(testx) ) { echo "***TITEL testx added!<br />"; $class->enqueue(testx);}

$class->save();

echo "#######<br />";
$class->printValues();

?>

