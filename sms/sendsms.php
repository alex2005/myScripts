<?

function sendsms($number, $text, $flash) {
  $filename = "/var/spool/sms/outgoing/sms-" .date("siH");
  if (($handle = fopen($filename .".LOCK", "w")) != false)
  {
    $l = strlen($st = "To: $number\n");
    fwrite($handle, $st);
    $text = mb_convert_encoding($text, "ISO-8859-15", "UTF-8");

    if ($flash != "")
    {
      $l += strlen($st = "Flash: yes\n");
      fwrite($handle, $st);
    }
    $l += strlen($st = "Adjustment: +");
    fwrite($handle, $st);
    $pad = 14 - $l % 16 + 16;
    while ($pad-- > 0)
      fwrite($handle, "+");
    fwrite($handle, "\n\n$text");
    fclose($handle);

    if (($handle = fopen($filename .".LOCK", "r")) == false)
      print "Unable to read message file.<br>";

    if (! $debug)
    {
      if (rename($filename .".LOCK", $filename) == true)
        print "SMS wurde f&uuml;r den Versand vorbereitet.<br>Dateiname: $filename<br>\n";
      else
        print "FAILED!<br>\n";
    }
  }
  else
    print "FAILED!<br>\n";


   return 1;
 }


?>
