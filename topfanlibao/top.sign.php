<?php
//使用前请看文档http://wiki.open.taobao.com/index.php/%E5%BA%94%E7%94%A8%E4%B8%8A%E4%B8%8B%E6%96%87%E5%8D%8F%E8%AE%AE
header("Content-Type:text/html;charset=UTF-8");
require_once 'util.php';

$appKey = 'test';
$appSecret = 'test';

//回调的参数
$top_appkey = $_GET['top_appkey'];
$top_parameters = $_GET['top_parameters'];
$top_session = $_GET['top_session'];
$app_secret = $appSecret;
$top_sign = $_GET['top_sign'];
//签名验证
$sign=base64_encode(md5($top_appkey.$top_parameters.$top_session.$app_secret,true));
if($sign!=$top_sign){
    echo '验证失败，请返回';
    exit;
}
//验证通过，解析top_parameters
$top_parameters = base64_decode($top_parameters);
print_r($top_parameters);
?>