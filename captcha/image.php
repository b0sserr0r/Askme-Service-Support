<?php

//image.php

session_start();


$random_alpha = md5(rand());
echo $random_alpha;
$captcha_code = substr($random_alpha, 0, 6);

$_SESSION['captcha_code'] = $captcha_code;

header('Content-Type: image/png');

$image = imagecreatetruecolor(200, 38);

$background_color = imagecolorallocate($image, 231, 100, 18);

$text_color = imagecolorallocate($image, 255, 255, 255);

imagefilledrectangle($image, 0, 0, 200, 38, $background_color);

//$font = dirname(__FILE__) . '/arial.ttf';
$font =  'arial.ttf';

imagettftext($image, 20, 0, 60, 28, $text_color, $font, $captcha_code);

imagepng($image);

imagedestroy($image);

?>