<?
error_reporting(0);
//图片地址base64加密
//$tu = base64_encode('http://img07.taobaocdn.com/bao/uploaded/i7/T15PRpXm8mXXb96CMV_021657.jpg_310x310.jpg');
$tu = $_GET['tu'];
$tupian = base64_decode($tu);
Header("Content-type: image/jpeg");
$im = imagecreatefromjpeg("$tupian");
Imagejpeg($im);
ImageDestroy($im);
?>