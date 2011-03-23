<?

require ("config.php");
require ("connect.php");
include ("header.inc.php");

?>

<div id="Header">Kontakte anzeigen</div>
<div id="Content">

<table width="400" cellspacing="0" cellpadding="2">
<tr align="left">
	<th><font face="verana, arial, helvetica" size="2">Name</font></th>
	<th><font face="verana, arial, helvetica" size="2">Handynummer</font></th>
</tr>
<?

$sql = "SELECT ID, Name, Number, Email FROM contact";

If (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   	}
	else
	{
	
	while($row = mysql_fetch_array($result)) {
		
		$ID = $row[0];
		$Name = $row[1];
		$Number = $row[2];
		$Email = $row[3];
		
		echo "<tr>";
		echo "<td><font face=\"verdana\" size=\"2\"><b>$Name</b></font></td>";
		echo "<td><font face=\"verdana\" size=\"2\">$Number</font></td>";
		echo "</tr>";
		
		}
	}

mysql_close();
?>
</table>
</div>
</body>
</html>
