<?php
//taobao.product.get:获取一个产品的信息
//使用前请看文档http://open.taobao.com/dev/index.php/API2.0:Taobao.product.get
header("Content-Type:text/html;charset=UTF-8");
require_once '../util.php';
require_once '../config.php';

//参数数组
$paramArr = array(
    'app_key' => $appKey,//TOP分配给应用的AppKey
    'method' => 'taobao.product.get',//API接口名称
    'format' => 'xml',//可选，指定响应格式。默认xml,目前支持格式为xml,json
    'v' => '2.0',//API协议版本，可选值:1.0,2.0。某些新的api可能只有2.0版本。
    'timestamp' => date('Y-m-d H:i:s'),//时间戳，格式为yyyy-mm-dd hh:mm:ss，例如：2008-01-25 20:23:30。
    'fields' => 'product_id,cat_name,props,name',//需返回的字段列表。
    'product_id' => '86126527',//Product的id.两种方式来查看一个产品:1.传入product_id来查询 2.传入cid和props来查询
    //'cid' => '16',//商品类目id.调用taobao.itemcats.get获取;必须是叶子类目id,如果没有传product_id,那么cid和props必须要传.
    //'props' => '20000:5410713;4890453:13445209'//关键属性列表.调用taobao.itemprops.get获取类目属性,如果属性是关键属性,再用taobao.itempropvalues.get取得vid.格式:pid:vid;pid:vid.
//比如:诺基亚N73这个产品的关键属性列表就是:品牌:诺基亚;型号:N73,对应的PV值就是10005:10027;10006:29729.

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
highlight_file('taobao.product.get.php');
?>