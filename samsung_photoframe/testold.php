<?php
header('Content-type: text/html; charset=ISO-8859-1');

	$dst = imagecreatetruecolor( 800, 600 );
	$src = imagecreatefromjpeg( 'wasserturm.jpg' );
        //$src = imagecreatefromjpeg( 'http://webcam01.manet.de/images/image_cam.jpg' );
	$src1 = imagecreate( 344, 320 );
	$src2 = imagecreate( 780, 250 );
	$src3 = imagecreatefromgif( 'chance_of_rain.gif' );
	
	$img_w = imagesx($dst);
	$img_h = imagesy($dst);
	
	//imagecopyresampled( $dst, $src, 10, 10, 0, 0, 426, 320, 640, 480 );
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
	$text2 = "Meistens bewölkt, Wind: W mit 14 km/h";
	$text3 = "7 Grad C, Feuchtigkeit: 74%";
	
	//imagefill($dst, 0, 0, $white);
	imagefilledrectangle($dst, 10, 10, 790, 590, $light_blue);
	// Font size
	$size = "20";
	$weathersize = "10";
	
	// Draw the text 'PHP Manual' using font size 13
	//imagefttext($dst, 13, 0, 20, 400, $red, $font, 'PHP Manual');
	//imagestring($dst, 200, 20, 410, 'Hello world!', $red);

	// Add the text to the canvas
	// Write the string at the top left
	
	//imagecopymerge( $dst, $src1, 446, 10, 0, 0, 344, 320, 30 );
	//imagecopymerge( $dst, $src2, 10, 340, 0, 0, 780, 250, 30 );
	imagecopyresampled( $dst, $src, 10, 10, 0, 0, 426, 320, 640, 480 );

	// weather
	imagecopymerge( $dst, $src3, 456, 200, 0, 0, 40, 40, 100 );
	imageTTFText( $dst, $weathersize, 0, 456, 255, $white, $font, $text2 );
	imageTTFText( $dst, $weathersize, 0, 456, 270, $white, $font, $text3 );

	imageTTFText( $dst, $size, 0, 20, 380, $white, $font, $text );
	// schatten
	imageTTFText( $dst, $size, 0, 23, 383, $black, $font, $text );
	
	//imagestring($dst, $size, round(($img_w/2)-((strlen($text)*
	//imagefontwidth($font_size))/2), 1), round(($img_h/2)-(imagefontheight($font_size)/2)),
	//$text, $white);
	//imagestring($dst, $size, round(($img_w/2)-((strlen($text)*imagefontwidth($size))/2), 1), 420, $text, $white);

	header( 'Content-type: image/jpeg' );
	imagejpeg( $dst );
	imagedestroy( $src );
	imagedestroy( $src1 );
	imagedestroy( $src2 );
	imagedestroy( $src3 );
	imagedestroy( $dst );


?>
