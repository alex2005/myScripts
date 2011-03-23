<?

require ("../config.php");
require ("../connect.php");
include ("../header.inc.php");

parse_str($_SERVER['QUERY_STRING']);

?>
<div id="Header">Verschickte SMS anzeigen</div>
<div id="Content">

<table border="0" width="400" cellspacing="0" cellpadding="0">
<?

if ($sent==1) {$table=messages;} else {$table=incoming;}

$sql = "SELECT MessageID, Name, Message, Datum, Number FROM $table WHERE MessageID='$MessageID'";

If (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   	}
	else
	{
	
	while($row = mysql_fetch_array($result)) {
		
		$MyID = $row[0];
		$MyName = $row[1];
		$MyMessage = $row[2];
		$MyDate = $row[3];
		$MyNumber = $row[4];

		echo "<tr>\n";
		echo "<td width=\"400\"><font face=\"verana, arial, helvetica\" size=\"2\">SMS an 
		<a href=\"../send_ind.php?Number=+$MyNumber\"><b>$MyName [+$MyNumber]</b></a>, gesendet am $MyDate<br><br>\n";
		echo "$MyMessage</font></td>\n";
		echo "</tr>\n";
	
		}
	}

mysql_close();

?>
</table>
</div>
</body>
</html>
