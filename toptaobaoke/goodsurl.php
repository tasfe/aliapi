<?php
error_reporting(0);
$aid=$_GET['aid'];
require_once 'util.php';

//参数数组
$paramArr = array(
    'app_key' => $appKey, 
    'method' => 'taobao.taobaoke.items.convert', 
    'format' => 'xml', 
    'v' => '1.0', 
    'timestamp' => date('Y-m-d H:i:s'), 
	'fields' => 'click_url',
    'iids' => $aid, 
    'nick' => $usernick,
	
);

//生成签名
$sign = createSign($paramArr);

//组织参数
$strParam = createStrParam($paramArr);
$strParam .= 'sign='.$sign;

//访问服务
$url = 'http://gw.api.taobao.com/router/rest?'.$strParam;
$result = file_get_contents($url);
$result = getXmlData($result);
$url = $result['taobaokeItem']['click_url'];

if (empty($aid)) {
header('Location: http://www.7895123.com.cn/');
exit;
}
header("Location: $url");
exit;
?>