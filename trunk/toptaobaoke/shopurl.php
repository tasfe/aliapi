<?php
error_reporting(0);
$aid=$_GET['aid'];
require_once 'util.php';

//参数数组
$paramArr = array(
    'app_key' => $appKey, 
    'method' => 'taobao.shop.get', 
    'format' => 'xml', 
    'v' => '1.0', 
    'timestamp' => date('Y-m-d H:i:s'), 
    'fields' => 'sid', 
    'nick' => $aid,
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
$sid = $result['shop']['sid'];

//参数数组
$paramArr = array(
    'app_key' => $appKey, 
    'method' => 'taobao.taobaoke.shops.convert', 
    'format' => 'xml', 
    'v' => '1.0', 
    'timestamp' => date('Y-m-d H:i:s'), 
    'fields' => 'click_url,user_id,shop_title',
	'sids' => $sid,
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
$url = $result['taobaokeShop']['click_url'];

if (empty($aid)) {
header('Location: http://www.7895123.com.cn/');
exit;
}
header("Location: $url");
exit;
?>