<?php
$tccc=$_GET['catid'];
$tkeyword=$_GET['keyword'];
if (empty($tccc)) {
echo '分类首页';
}
?>
<?php
if ($tkeyword==null) {
$ccc=$_GET['catid'];
$myFile  =  file(  "converter.php");
$allnum=count($myFile); 
for ($i=1;$i<$allnum;$i++){
$m=explode(",",$myFile[$i]);
$xiabiao=trim($m[0]);
if ($xiabiao==$ccc) {
	echo $m[2];
}
}
}else {
	echo $tkeyword;
}
?>