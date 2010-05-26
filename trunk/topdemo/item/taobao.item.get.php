<?php
//taobao.item.get :得到单个商品信息
//使用前请看文档http://open.taobao.com/dev/index.php/API2.0:Taobao.item.get
header("Content-Type:text/html;charset=UTF-8");
require_once '../util.php';
require_once '../config.php';

//参数数组
$paramArr = array(
    'app_key' => $appKey,//TOP分配给应用的AppKey
    'method' => 'taobao.item.get',//API接口名称
    'format' => 'xml',//可选，指定响应格式。默认xml,目前支持格式为xml,json
    'v' => '2.0',//API协议版本，可选值:1.0,2.0。某些新的api可能只有2.0版本。
    'timestamp' => date('Y-m-d H:i:s'),//时间戳，格式为yyyy-mm-dd hh:mm:ss，例如：2008-01-25 20:23:30。
    'fields' => 'title,nick,pic_url,post_fee',//需返回的字段列表。
    'nick' => 'tbtest',//卖家昵称,如果昵称为中文，要用UTF-8编码
    'iid' => 'd8e936b33551d9d5999bda1a57f1f897'//商品id
    //'num_iid' => '12324527'//商品数字id
);

//生成签名
$sign = createSign($paramArr);

//组织参数
$strParam = createStrParam($paramArr);
$strParam .= 'sign='.$sign;

//访问服务
//测试环境http://gw.api.tbsandbox.com/router/rest
//正式环境http://gw.api.taobao.com/router/rest
$url = 'http://gw.api.taobao.com/router/rest?'.$strParam;
$result = file_get_contents($url);
$result = getXmlData($result);
print_r($result);
echo '<br />----------------源代码----------------<br />';
highlight_file('taobao.item.get.php');
?>