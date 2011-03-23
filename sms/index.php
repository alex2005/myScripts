<?php
require ("config.php");
require ("connect.php");
include ("header.inc.php");
?>

<div id="Header">Herzlich Willkommen</div>

<div id="Content">
<table border=0 cellspacing=5 width=350>
<th align=left colspan=2>K&uuml;rzlich gesendet</th>
<?
$sql = "SELECT MessageID, Name, Datum FROM messages ORDER BY MessageID DESC LIMIT 3";
if (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   	}
	else
	{
	
	while($row = mysql_fetch_array($result)) {
		
		$MyID = $row[0];
		$MyName = $row[1];
		$MyDate = $row[2];
		
		echo "<tr><td><a href=\"admin/showmessage.php?MessageID=$MyID&sent=1\">$MyName</a></td><td>$MyDate</td></tr>\n";
		}
	}
$sql = "SELECT MessageID, Name, Number, Datum FROM incoming ORDER BY Datum DESC LIMIT 3";
if (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   	}
	else
	{
	echo "<th align=left colspan=2>K&uuml;rzlich empfangen</th>";
	while($row = mysql_fetch_array($result)) {
		
		$MyID = $row[0];
		$MyName = $row[1];
		$MyNumber = $row[2];
		$MyDate = $row[3];
		echo "<tr><td><a href=\"admin/showmessage.php?MessageID=$MyID&incoming=1\">";
		if ($MyName) {echo $MyName; }else {echo $MyNumber;}
		echo "</a></td><td>$MyDate</td></tr>\n";
		}
	}

mysql_close();

?>

</table>

</div>
</body>

</html>
