<?php
//taobao.itemcats.get:获取后台供卖家发布商品的标准商品类目
//使用前请看文档http://open.taobao.com/dev/index.php/API2.0:Taobao.itemcats.get
header("Content-Type:text/html;charset=UTF-8");
require_once '../util.php';
require_once '../config.php';

//参数数组
$paramArr = array(
    'app_key' => $appKey,//TOP分配给应用的AppKey
    'method' => 'taobao.itemcats.get',//API接口名称
    'format' => 'xml',//可选，指定响应格式。默认xml,目前支持格式为xml,json
    'v' => '2.0',//API协议版本，可选值:1.0,2.0。某些新的api可能只有2.0版本。
    'timestamp' => date('Y-m-d H:i:s'),//时间戳，格式为yyyy-mm-dd hh:mm:ss，例如：2008-01-25 20:23:30。
    'fields' => 'cid,parent_cid,name,is_parent',//需返回的字段列表。
    'parent_cid' => '0',//父商品类目 id，0表示根节点, 传输该参数返回所有子类目。 (cids、parent_cid至少传一个)
    //'cids' => '16',//商品所属类目ID列表，用半角逗号(,)分隔 例如:(18957,19562,) (cids、parent_cid至少传一个)
    //'datetime' => '1970-01-01 00:00:00'//时间戳。格式:yyyy-MM-dd HH:mm:ss
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
highlight_file('taobao.itemcats.get.php');
?>