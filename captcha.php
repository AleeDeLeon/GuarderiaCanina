<?php
session_start();

$captcha = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ123456789"), 0, 5);
$_SESSION["captcha"] = $captcha;

header('Content-Type: image/png');
$image = imagecreate(100, 30);
$bg = imagecolorallocate($image, 255, 255, 204); // fondo amarillito pastel
$textColor = imagecolorallocate($image, 0, 0, 0);

imagestring($image, 5, 10, 7, $captcha, $textColor);
imagepng($image);
imagedestroy($image);
