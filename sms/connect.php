<?

require ("config.php");

if (! @$cc=mysql_connect("$MySQL_Host","$MySQL_User","$MySQL_Passw")) {
   echo "Die Verbindung zu ",$MySQL_Host," konnte nicht hergestellt werden<br>";
   exit;
}

if ($debug) { echo "<b>DEBUG: $MySQL_Host $sql $db</b><br>"; }

function send_sql($db, $sql) {
   if (! $res=mysql_db_query($db, $sql)) {
   echo mysql_error();
   exit;
   }
   return $res;
 }


function return_rows($source) {
	
	if (! $row=mysql_fetch_array($source)) {
	echo mysql_error();
	exit;
	}
return $row;
}
?>
