<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>SMS Gateway</title>
<script language="JavaScript">

<? $webpath="/download/sms"; ?>

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
<style type="text/css" media="all">@import "<? echo $webpath; ?>/layout.css";</style>
</head>

<body>

<div id="Logo">
	SMS Gateway
</div>

<div id="Menu">
	<a href="<? echo $webpath; ?>/index.php" title="Startseite">Startseite</a><br />
	<a href="<? echo $webpath; ?>/show.php" title="Mitarbeiter anzeigen">Empf&auml;nger anzeigen</a><br />
	<!--a href="<? echo $webpath; ?>/send.php" title="SMS verschicken">SMS verschicken</a><br /-->
	<a href="<? echo $webpath; ?>/send_ind.php" title="SMS verschicken">SMS verschicken</a><br />
	<a href="<? echo $webpath; ?>/admin/messagelist.php" title="Messagelist">Messagelist</a><br />
	<a href="<? echo $webpath; ?>/admin/index.php" title="Administration">Administration</a><br />
	<!--a href="new.php" title="Kontakt hinzuf&uuml;gen">Kontakt hinzuf&uuml;gen</a><br /-->
</div>
