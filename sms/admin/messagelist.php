<?

require ("../config.php");
require ("../connect.php");
include ("../header.inc.php");

$zellen=0;

?>
<div id="Header">SMS Liste anzeigen</div>
<div id="Content">
<table border=1 cellspacing=4 width=600><th>Verschickt</th><th>Empfangen</th>
<tr><td width=50%><table border=0 width=100%>
<?

$sql = "SELECT MessageID, Name, Datum FROM messages ORDER BY MessageID DESC LIMIT 10";

If (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   	}
	else
	{
	
	while($row = mysql_fetch_array($result)) {
		
		$MyID = $row[0];
		$MyName = $row[1];
		$MyDate = $row[2];
		
		echo "<font face=\"verana, arial, helvetica\" size=\"2\"><tr";
		if ($zellen % 2) { echo " style=\"background-color:#FFCC66\""; }
		echo "><td><a href=\"showmessage.php?MessageID=$MyID&sent=1\">$MyName</a></td><td>$MyDate</td></tr></font>\n";
		$zellen++;
		}
	}
?>

</table>

</td><td><table border=0 width=100%>
<?
$sql = "SELECT MessageID, Name, Number, Datum FROM incoming ORDER BY Datum DESC LIMIT 10";

If (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   	}
	else
	{
	
	while($row = mysql_fetch_array($result)) {
		
		$MyID = $row[0];
		$MyName = $row[1];
		$MyNumber = $row[2];
		$MyDate = $row[3];
		$zellen++;
		echo "<font face=\"verana, arial, helvetica\" size=\"2\"><tr";
		if ($zellen % 2) { echo " style=\"background-color:#CCFF66\""; }
		echo "><td><a href=\"showmessage.php?MessageID=$MyID&incoming=1\">";
		if ($MyName) {echo $MyName; }else {echo $MyNumber;}
		echo "</a></td><td>$MyDate</td></tr></font>\n";
		}
	}

mysql_close();

?>
</td></tr></table>
</table>
</div>
</body>
</html>
