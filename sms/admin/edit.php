<?

require ("../config.php");
require ("../connect.php");
include ("../header.inc.php");

//parse_str($_SERVER['$QUERY_STRING']);

if ($_GET) {
$ID=$_GET['ID'];
}

if ($_POST) {
$submit=$_POST['submit'];
$Number=$_POST['Number'];
$Name=$_POST['Name'];
}


if ($debug) { echo "<b>DEBUG: $submit $ID $Name $Number</b><br>"; }

$sql = "SELECT ID, Name, Number, Email FROM contact WHERE ID = '$ID'";
if ($debug) { echo "<b>DEBUG: $sql</b><br>"; }

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
		$MyEmail = $row[3];
	
		}
	}

//mysql_close();

?>

<div id="Header">Kontakt editieren</div>
<div id="Content">

<?
if ($submit) {

$sql="UPDATE contact SET Name='$Name', Number='$Number', Email='$Email' WHERE ID='$ID'";
if ($debug) { echo "<b>DEBUG: $sql</b><br>"; }

if (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-command was not executed!<br>";
   	}
	else
	{
?>
<font face="verdana, arial, helvetica" size="2">Die &Auml;nderungen wurden &uuml;bernommen... <a href="show.php">Hier</a> klicken um
zur&uuml;ckzukommen!</font>
<?	

	mysql_close();
	}
}
else {
?>
<form name="new" method="post" action="<? echo $PHP_SELF; ?>">
  <table width="350" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><font face="verdana, arial, helvetica" size="2">Name</font></td>
      <td>
        <input type="text" name="Name" value="<? echo $MyName; ?>">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font face="verdana, arial, helvetica" size="2">Handynummer</font></td>
      <td>
        <input type="text" name="Number" value="<? echo $MyNumber; ?>">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
  	<td><input type="hidden" name="ID" value="<? echo $MyID; ?>"></td>
      <td>
        <input type="submit" name="submit" value="&Auml;ndern">
      </td>
    </tr>
  </table>
</form>
</div>
<?
}
?>
</body>
</html>
