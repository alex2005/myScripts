<?

require ("../config.php");
require ("../connect.php");
include ("../header.inc.php");

?>

<div id="Header">Kontakte anzeigen</div>
<div id="Content">

<table width="500" cellspacing="0" cellpadding="2">
<tr align="left">
	<th><font face="verana, arial, helvetica" size="2">Name</font></th>
	<th><font face="verana, arial, helvetica" size="2">Handynummer</font></th>
	<!--th><font face="verana, arial, helvetica" size="2">Email address</font></th-->
	<th><font face="verana, arial, helvetica" size="2">Aktion</font></th>
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
		echo "<!--td><font face=\"verdana\" size=\"2\">$Email</font></td-->";
		echo "<td><font face=\"verdana\" size=\"2\"><a href=\"edit.php?ID=$ID\">&Auml;ndern</a>&nbsp;&nbsp;<a
		href=\"delete.php?ID=$ID\">L&ouml;schen</a></font></td>";
		echo "</tr>";
		
		}
	}

mysql_close();
?>
</table>
<font face="verana, arial, helvetica" size="2">Keine Umlaute und dergleichen benutzen! (&auml;,&ouml;,&uuml;,...)</font>
</div>
</body>
</html>
