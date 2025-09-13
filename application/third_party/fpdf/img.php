<?php
// Set the content-type
header('Content-Type: image/png');
header('Character set: utf8');


function properText($text){
    $text = mb_convert_encoding($text, "HTML-ENTITIES", "UTF-8");
    $text = preg_replace('~^(&([a-zA-Z0-9]);)~',htmlentities('${1}'),$text);
    return($text); 
}
// Create the image
$im = imagecreatetruecolor(400, 30);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $white);


// The text to draw
$text = " à¤¨à¤®à¤¸à¥à¤¤à¥‡ ";
// Replace path by your own font path
$font = 'arialuni.ttf';

//$text=utf8_decode($text);
//$text=iconv('UTF-8','windows-1252',$text);
// Add some shadow to the text
imagettftext($im, 20, 0, 11, 21, $grey, $font, properText($text));

// Add the text
imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?>