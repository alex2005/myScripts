<? 

require ("config.php");
require ("connect.php");
require ("sendsms.php");
include ("header.inc.php");

global $db;
function myreadfile ($file)
{
    $fh = fopen($file, 'r');
    while(!feof($fh))
  	{
	$line = fgets($fh);
  		if (preg_match("/^From: 49/", $line)) {
  		echo $line."<br \>\n";
		
}
  	}
	echo (`tail -1 $file`);
    fclose($fh);
}

  function getDirectoryList ($directory) 
  {
    // create an array to hold directory list
    $results = array();
    // create a handler for the directory
    $handler = opendir($directory);
    // open directory and walk through the filenames
    while ($file = readdir($handler)) {
      // if file isn't this directory or its parent, add it to the results
      if ($file != "." && $file != "..") {
        $results[] = $file;
      }
    }
    // tidy up: close the handler
    closedir($handler);
    // done!
    return $results;
  }


if ($debug) { echo "<b>DEBUG: $submit $ID $Name $Number</b><br>"; }

?>
<div id="Header">Incoming SMS anzeigen</div>
<div id="Content">

<!--body bgcolor="#FFFFFF" marginwidth="7" marginheight="30" topmargin="30" leftmargin="7" onLoad="Init()"-->
<body bgcolor="#FFFFFF" marginwidth="7" marginheight="30" topmargin="30" leftmargin="7">
<table width="500"border=1 cellpadding=0 cellspacing=0>
<tr>
<td>
<table border=1 cellpadding=0 cellspacing=3>
<?
	foreach (getDirectoryList ("/var/spool/sms/incoming/") as $file) {
		myreadfile ("/var/spool/sms/incoming/$file");
	}
	
?>
</table>
</td>
</tr>
</table>

</div>

</body>
</html>
