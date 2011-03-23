<?

require ("../config.php");
require ("../connect.php");

include ("../header.inc.php");

//parse_str($_SERVER['QUERY_STRING']);

if ($_POST) {
$sent=$_POST['sent'];
$submit=$_POST['submit'];
$Number=$_POST['Number'];
$Name=$_POST['Name'];
}

if ($debug) { echo "<b>DEBUG: $submit $sent $Name $Number</b><br>"; }

if ($sent<1) {
$i = 0;
}
else {
$i=$i+1;
}

?>
<div id="Header">Kontakt hinzuf&uuml;gen</div>
<div id="Content">

<?

if ($submit && $sent<2) {
	
	$Cut = substr($Number,0,3);
	
	$NewNumber = str_replace(" ","",$Number);
	$NewNumber = str_replace("-","",$NewNumber);
	$NewNumber = str_replace($Cut,"0",$NewNumber);
	$Emailstring = $NewNumber . "@" . $Email;
	
	$sql="INSERT INTO contact (ID, Name, Number, Email) VALUES ('', '$Name', '$Number', '$Emailstring')";
	if ($debug) { echo "<b>DEBUG: $sql</b><br>"; }

if (!$result=send_sql($db,$sql))  
	{
   	echo "SQL-command was not executed!<br>";
   	}
	else
	{
	echo "<font face=\"verdana, arial, helvetica\" size=\"2\">Der neue Kontakt wurde angelegt! <a href=\"show.php\">Hier</a> klicken<br>um
	alle Kontakte zu sehen.</font>";
	}
} else {
?>
<font face="verana, arial, helvetica" size="2">Keine Umlaute und dergleichen benutzen! (&auml;,&ouml;,&uuml;,...)</font>
<form method="post" action="<? echo $PHP_SELF; ?>">
  <table width="450" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><font face="verana, arial, helvetica" size="2">Name</font></td>
      <td>
        <input type="text" name="Name">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font face="verana, arial, helvetica" size="2">Handynummer</font></td>
      <td>
        <input type="text" name="Number">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><font face="verana, arial, helvetica" size="2">Bitte in Standardnotation (z.B. +49 f&uuml;r Deutschland gefolgt<br>von der
      gew&uuml;nschten Handynummer)</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="hidden" name="sent" value="<? echo $i+1; ?>"></td>
      <td>
        <input type="submit" name="submit" value="Eintragen">
      </td>
    </tr>
  </table>
  
</form>
</div>
</body>
</html>
<?
}
mysql_close();
?>
