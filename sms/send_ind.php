<? 

require ("config.php");
require ("connect.php");
require ("sendsms.php");
include ("header.inc.php");

global $db;

if ($_GET) {
$Number=$_GET['Number'];
	if(substr($Number,0,1)==' ') {
		$Number=substr($Number, 1, strlen($Number));
		$Number="+".$Number;
	} 
}

if ($_POST) {
$submit=$_POST['submit'];
$mode=$_POST['mode'];
$contact=$_POST['contact'];
$Number=$_POST['Number'];
$message=$_POST['message'];
$flash=$_POST['flash'];
}


if ($debug) { echo "<b>DEBUG: $submit $ID $Name $Number</b><br>"; }

?>
<html>
<head>
<title>SMS gateway</title>
<script language="JavaScript">

var supportsKeys = false
var maxlength = <? echo $MaxLengthOfMessage; ?>

function Init() {
	
	check();
}

function getLength(what) {

	if (what.value.length > maxlength) {
		
		what.value = what.value.substring(0,maxlength)
		charsleft = 0
		
	}
	else {
		
		charsleft = maxlength - what.value.length
		
	}
	
	document.forms[0].elements['charsleft'].value = charsleft
	
}

function check() {
	
	getLength(document.forms[0].elements['message'])
	if (!supportsKeys) timerID = setTimeout("check()",300)
}

</script>
</head>

<body bgcolor="#FFFFFF" marginwidth="7" marginheight="30" topmargin="30" leftmargin="7" onLoad="Init()">

<div id="Header">SMS verschicken</div>
<div id="Content">

<table width="500"border=0 cellpadding=0 cellspacing=0>
<tr>
<td>
<table border=0 cellpadding=0 cellspacing=3>
<?
$dir = '/dev/ttyACM0';
if(!file_exists($dir))
{
	print "<b>SMS Versand nicht m&ouml;glich, bitte kontaktieren sie <a href=mailto:md@baeckerei-kohlmann.de>Markus Dorn</a></b><br>";
	exit();
}

if ($submit=="") {
?>
<form method=POST action="<? echo $PHP_SELF; ?>">
<tr>
	<th colspan=2 align="left"><font face="verdana, arial, helvetica" size="2">SMS Nachricht verschicken</font><br><br></th>
</tr>
<tr>
	<td><font face="verdana, arial, helvetica" size="2">Senden an:</font></td>
	<td><select name="contact">
	<?
			echo "<option value=\"null\"></option>";
	
	$sql = "SELECT Name FROM contact ORDER BY Name ASC";

	If (!$result=send_sql($db,$sql))  
		{
   		echo "SQL-Kommando wurde nicht ausgef&uuml;hrt<br>";
   		}
		else
		{
	
		while($row = mysql_fetch_array($result)) {
		
			$Name = $row[0];
	
			echo "<option value=\"$Name\">$Name</option>";
			}
		}
	?>
	</select>
    	<input type=hidden name="mode" value="sms">
	<font face="verdana, arial, helvetica" size="2"><b>oder</b></font> <input size=17 type="text" name="Number" value="<? 
	if ($Number) { 
		if(substr($Number,0,1)=='0') {
			$Number=substr($Number, 1, strlen($Number));
			$Number="+49".$Number;
		} 
		echo $Number; 
	
	} else {echo "+49"; } ?>">
	</td>

</tr>
<tr>
	<td colspan=2 align=right><font face="verdana, arial, helvetica" size="2">
	<input type='checkbox' name='flash' value='Y'>Flash SMS</font></td>

</tr>

<tr>
	<td><font face="verdana, arial, helvetica" size="2">Nachricht:</font></td>
	<td><textarea name="message" cols="40" rows="6"></textarea></td>
</tr>
<tr>
	<td><font face="verdana, arial, helvetica" size="2">Buchstaben &uuml;brig:</font></td>
	<td><input type="text" name="charsleft" size="3"></td>
</tr>
<tr>
	<td colspan=2 align=center><input type=submit value="Abschicken" name="submit"></td>
</tr>
</form>
<? } ?>
</table>
</td>
</tr>
</table>
<?

if ($mode == "sms") {

	{
if ($debug) { echo "<b>DEBUG: $contact $submit $ID $Name $Number</b><br>"; }
	
	if ($contact=="null") {
		$phonenumber = trim($Number);
	} else {
		$sql = "SELECT Number FROM contact WHERE Name='$contact'";
		if (!$result=send_sql($db,$sql))  
			{
   			echo "SQL-command was not executed!<br>";
   			}
			else
			{

			while($row = mysql_fetch_array($result)) {

				$phonenumber = trim($row[0]);

				}
			}
	}
	
	
		
	$phonenumber = str_replace(" ","",$phonenumber);
	$phonenumber = str_replace("-","",$phonenumber);
	$phonenumber = str_replace("+","",$phonenumber);

	echo "<pre>\n";
	if( sendsms($phonenumber, $message, $flash) )
		{
		echo "<br><b>SMS Nachricht erfolgreich verschickt.</b><br>";
		};
	echo "</pre>\n";
	}
}

if ($submit || $mode) {

	// save message into db
	
	$thedate = date("Y-d-m H:i:s");

	if ($contact=="null") {
	$contact = trim($Number);
	}
	$sql="INSERT INTO messages (MessageID, Name, Message, Datum) VALUES ('', '$contact', '$message', '$thedate')";

	If (!$result=send_sql($db,$sql))  
		{
   		echo "SQL-command was not executed!<br>";
   		}
		else
		{
			if ($debug) { echo "<b>Nachricht in DB gespeichert.</b>"; }
		}

}
mysql_close();
?>
</body>
</html>
