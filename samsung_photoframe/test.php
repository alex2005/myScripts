<?php
header('Content-type: text/html; charset=ISO-8859-1');

$dst = imagecreatetruecolor( 800, 600 );

//$src = imagecreatefromjpeg( 'wasserturm.jpg' );
$src2 = imagecreatefromgif( 'logo_morgenweb.gif' );
$src = imagecreatefromjpeg( 'http://webcam01.manet.de/images/image_cam.jpg' );
//$src2 = imagecreatefromjpeg( '' );

// First colour - this will be the default colour for the canvas
$light_blue = imagecolorallocate( $dst, 176, 226, 255 );
// The second colour - to be used for the text
$black = imagecolorallocate( $dst, 0, 0, 0 );
$white = imagecolorallocate( $dst, 255, 255, 255 );
$red = imagecolorallocate($dst, 0xFF, 0x00, 0x00);
// Path to the font you are going to use
$font = "./Verdana.ttf";
// Text to write
$text = "Alles Gute zu Deinem Geburtstag";

//imagefill($dst, 0, 0, $white);
imagefilledrectangle($dst, 10, 10, 790, 590, $light_blue);
// Font size
$size = "15";
$weathersize = "13";

// Wasserturm einfuegen
imagecopyresampled( $dst, $src, 10, 10, 0, 0, 426, 320, 640, 480 );

// Aktuelles Wetter Koordinaten
$weatherx=450;
$stepx=0;
$weathery=30;
$stepy=20;
$icony=58;

// weather
//$xml_filename="./weather.xml";
$xml_filename="http://www.google.com/ig/api?weather=Mannheim;Deutschland&hl=de";
$xml_parser_handle = xml_parser_create();
if (!($parse_handle = fopen($xml_filename, 'r'))) {
	die("FEHLER: Datei $xml_filename nicht gefunden.");
}
while ($xml_data = fread($parse_handle, 4096))
{
	if (!xml_parse_into_struct($xml_parser_handle, $xml_data, $werte, $index))
	{
		die(sprintf('Weather XML error: %s at line %d',
		xml_error_string(xml_get_error_code($xml_parser_handle)),
		xml_get_current_line_number($xml_parser_handle)));
	}
}
xml_parser_free($xml_parser_handle);

if ( $werte[$index["FORECAST_DATE"][0]]["attributes"]["DATA"] != "" ) {
	$weatherdate=$werte[$index["FORECAST_DATE"][0]]["attributes"]["DATA"];
	$cond=$werte[$index["CONDITION"][0]]["attributes"]["DATA"];
	$wind=$werte[$index["WIND_CONDITION"][0]]["attributes"]["DATA"];
	$temp=$werte[$index["TEMP_C"][0]]["attributes"]["DATA"]." Grad C";
	$hum=$werte[$index["HUMIDITY"][0]]["attributes"]["DATA"];
	//$icon=imagecreatefromgif( 'mostly_cloudy.gif' );


	imageTTFText( $dst, $weathersize, 0, $weatherx, $weathery, $black, $font, "Aktuelles Wetter vom ".$weatherdate );
	imageTTFText( $dst, $weathersize, 0, $weatherx, $weathery+2*$stepy, $black, $font, $cond." bei ".$temp );
	imageTTFText( $dst, $weathersize, 0, $weatherx, $weathery+3*$stepy, $black, $font, $wind );
	imageTTFText( $dst, $weathersize, 0, $weatherx, $weathery+4*$stepy, $black, $font, $hum );
	if ($werte[$index["ICON"][0]]["attributes"]["DATA"] != ""){
        	$iconpath="http://www.google.com/" .$werte[$index["ICON"][0]]["attributes"]["DATA"];
        	$icon=imagecreatefromgif( $iconpath );
        	imagecopymerge( $dst, $icon, 750, $icony, 0, 0, 40, 40, 100 );
	}

	// Vorhersage
	$zaehler=0;
	$vory=$weathery+5*$stepy;
	while ( $zaehler <= 2 ) {

		$tag=$werte[$index["DAY_OF_WEEK"][$zaehler]]["attributes"]["DATA"];
		$cond=$werte[$index["CONDITION"][$zaehler+1]]["attributes"]["DATA"];
		$min=$werte[$index["LOW"][$zaehler]]["attributes"]["DATA"];
		$max=$werte[$index["HIGH"][$zaehler]]["attributes"]["DATA"];
		if ($werte[$index["ICON"][$zaehler]]["attributes"]["DATA"] != ""){
        		$iconpath="http://www.google.com/" .$werte[$index["ICON"][$zaehler]]["attributes"]["DATA"];
        		$icon=imagecreatefromgif( $iconpath );
        		imagecopymerge( $dst, $icon, 750, $vory+8, 0, 0, 40, 40, 100 );
		}
		$vory=$vory+$stepy;
		imageTTFText( $dst, $weathersize, 0, $weatherx, $vory, $black, $font, "Am ".$tag." ".$cond );
		$vory=$vory+$stepy;
		imageTTFText( $dst, $weathersize, 0, $weatherx, $vory, $black, $font, "Min/Max: ".$min."/".$max." Grad C" );
		$vory=$vory+$stepy;

		$zaehler = $zaehler + 1;
	}
} else {
		imageTTFText( $dst, $weathersize, 0, $weatherx, $weathery+5, $black, $font, "Leider keine Wetterdaten bekommen" );
}

// Newsticker

//$xml_filename="http://www.morgenweb.de/xml/newsticker.xml";
//$xml_filename="./newsticker.xml";
$xml_parser_handle = xml_parser_create();
if (!($parse_handle = fopen($xml_filename, 'r'))) {
        die("FEHLER: Datei $xml_filename nicht gefunden.");
}
while ($xml_data = fread($parse_handle, 4096))
{
        if (!xml_parse_into_struct($xml_parser_handle, $xml_data, $werte, $index))
        {
                die(sprintf('Newsticker XML error: %s at line %d',
                xml_error_string(xml_get_error_code($xml_parser_handle)),
                xml_get_current_line_number($xml_parser_handle)));
        }
}
xml_parser_free($xml_parser_handle);

// Aktuelles News Koordinaten
$newsx=20;
$newsy=380;
$stepy=23;

if ( $werte[$index["TITLE"][0]]["value"] != "" ){
	$news=$werte[$index["TITLE"][0]]["value"]." vom ";
	$newsdate=$werte[$index["LASTBUILDDATE"][0]]["value"];

	imageTTFText( $dst, $size, 0, $newsx, $newsy, $black, $font, $news.$newsdate );
	$zaehler=2;
	while ( $zaehler <= 7 ) {
        	$news=$werte[$index["TITLE"][$zaehler]]["value"];
		imageTTFText( $dst, $size, 0, $newsx, $zaehler*$stepy+$newsy, $black, $font, $news );
        	$zaehler = $zaehler + 1;
	}
	imagecopymerge( $dst, $src2, 575, 565, 0, 0, 215, 25, 100 );
} else {
	imageTTFText( $dst, $size+5, 0, $newsx, $zaehler*$stepy+$newsy+10, $black, $font, "Leider keine News :-(" );	
}

header( 'Content-type: image/jpeg' );
imagejpeg( $dst );
imagedestroy( $src );
imagedestroy( $src2 );
imagedestroy( $dst );


?>
