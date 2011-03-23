
<?

require ("../config.php");
require ("../connect.php");
include ("../header.inc.php");
?>
<div id="Header">Kontakt l&ouml;schen</div>
<div id="Content">
<?
parse_str($_SERVER['QUERY_STRING']);

$sql = "DELETE FROM contact WHERE ID='$ID'";

if ($debug) { echo "<b>$ID $sql</b>"; }


If (!$result=send_sql($db,$sql)) {
	
   		echo "SQL-command was not executed!";
   	}
	else
	{
		echo "<font face=\"verdana, arial, helvetica\" size=\"2\">Kontakt wurde erfolgreich gel&ouml;scht! <a href=\"show.php\">Hier</a>
		gehts zur &Uuml;bersicht!</font>";
	}

mysql_close();

?>
</div>
</body>
</html>
