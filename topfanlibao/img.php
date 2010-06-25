<?
error_reporting(0);
$getimg = $_GET['img'];
$geti = $_GET['i'];
$gettu = $_GET['tu'];
$getsize = $_GET['size'];
if (empty($getimg) || empty($geti) || empty($gettu) || empty($getsize)) {
	echo 'www.7895123.com.cn';
	exit;
}
$tupian = 'http://img'.$getimg.'.taobaocdn.com/bao/uploaded/i'.$geti.'/'.$gettu.'.jpg'.$getsize.'.jpg';
Header("Content-type: image/jpeg");
$im = imagecreatefromjpeg("$tupian");
Imagejpeg($im);
ImageDestroy($im);
?> 