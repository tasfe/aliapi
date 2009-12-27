<?php
//使用前请看文档http://wiki.open.taobao.com/index.php/API2.0:Taobao.user.get
header("Content-Type:text/html;charset=UTF-8");
require_once 'util.php';

$appKey = 'test';
$appSecret = 'test';

//参数数组
$paramArr = array(
    'app_key' => $appKey,
    'method' => 'taobao.user.get',
    'format' => 'xml',
    'v' => '2.0',
    'timestamp' => date('Y-m-d H:i:s'),
    'fields' => 'user_id,nick,sex,buyer_credit,seller_credit,location.country,created,last_visit,location.zip,birthday,type,has_more_pic,item_img_num,item_img_size,prop_img_num,prop_img_size,auto_repost,promoted_type,status,alipay_bind,consumer_protection',
    'nick' => 'alipublic01'
);

//生成签名
$sign = createSign($paramArr);

//组织参数
$strParam = createStrParam($paramArr);
$strParam .= 'sign='.$sign;

//访问服务
$url = 'http://gw.api.tbsandbox.com/router/rest?'.$strParam;
$result = file_get_contents($url);
$result = getXmlData($result);

print_r($result);
?>