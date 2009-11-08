<?php
error_reporting(0);
require_once 'util.php';
$nick = $_GET['nick'];
$iid = $_GET['aid'];

//参数数组
$paramArr = array(
    'app_key' => $appKey, 
    'method' => 'taobao.item.get', 
    'format' => 'xml', 
    'v' => '1.0', 
    'timestamp' => date('Y-m-d H:i:s'), 
	'fields' => 'iid,title,nick,pic_path,price,cid,num,desc',
    'iid' => $iid, 
    'nick' => $nick,
	
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
$title = $result['item']['title'];
$catid = $result['item']['cid'];
$desc = $result['item']['desc'];
$num = $result['item']['num'];
$price = $result['item']['price'];
$pic_path = $result['item']['pic_path'];
?>

<?php
include("header.php");
?>
<div class="listcontent">
<div class="nav"><a href="./">首页</a> &gt; <a href="category.php">所有分类</a> 
<?php
$ccc=$catid;

$myFile  =  file(  "converter.php");

$allnum=count($myFile); 
for ($i=1;$i<$allnum;$i++){
$m=explode(",",$myFile[$i]);
$xiabiao=trim($m[0]);
$name[$xiabiao]=$m[2];
$cat[$xiabiao][1]=$m[3];
$cat[$xiabiao][2]=$m[4];

}

$k[0]=$cat[$ccc][0];
$k[1]=$cat[$ccc][1];
$k[2]=$cat[$ccc][2];


$n_id  =explode(" ",$k[1]);
$n_name=explode(">>",$k[2]);
//print_r($k);

for ($i=0;$i<count($n_id);$i++){
if ($name[$n_id[$i]]=="null"){}
else{
echo " &gt; <a href=category.php?catid=".$n_id[$i].">".$name[$n_id[$i]]."</a>";
}
}

?>
</div>
<!-- 分类 -->
<div id="DivCategoryList" class="listall">
<div class="listalltt"><div class="listalltlf"></div><div class="listallrt"></div></div>
<div class="listallcont">
<h2><?php echo $title;?></h2>
</div>
<div class="listallbt"><div class="listallblf"></div><div class="listallbrt"></div></div>
</div>
<!-- /分类 -->

<div class="liebtt"><div class="lftt"><div class="lfttl">商品信息</div></div><div class="rttt"></div>
</div>
<div class="liebline">
<!-- 分页 -->
<div class="pager">
<div class="left"><a title="<?=$title?>" href="goodsurl.php?aid=<?=$iid?>" target="_blank"><img alt="<?=$title?>" src="<?=$pic_path?>" width="310" height="310" border="0" />
</a></div>
<div class="right">
<span id="lblPager">
<ul>
<li>商品标题：<?=$title?></li>
<li>商品数量：<?=$num?></li>
<li>卖家昵称：<?=$nick?></li>
<li>商品价格：<?=$price?>元</li>
<li>商品id：<?=$iid?></li>
<li><br /><br /><br /><br /><br /><br /><a href="goodsurl.php?aid=<?=$iid?>" title="<?=$title?>" target="_blank"><img src="img/cpasubmit.gif" alt="淘宝网购买链接" /></a></li>
</ul>
</span>
</div>
</div>
<!--/分页 -->
</div>
<div class="googlegg">
<div class="ng">
<div class="ngtitle">
<div class="left"><strong>淘宝客<span>推广</span>联盟</strong></div>
<div class="right">赞助商链接：<a href="http://www.7895123.com.cn/" target="_blank">免淘网</a> - 帮您淘宝，购物无忧</div>
</div>
<div id="ListAdsense">
<?php 
//$tbinfo = iconv("GBK","UTF-8",$desc);
//preg_match("/^var desc=\'(.*)\';$/isU",$content1,$con);
$pat = "/<(\/?)(script|i?frame|style|html|body|title|link|a|meta|\?|\%)([^>]*?)>/isU";
//$tbinfo = $con[1];
$abc=preg_replace($pat,"",$desc);
echo $abc;
?><br /><div align="center"><a href="goodsurl.php?aid=<?=$iid?>" title="<?=$title?>" target="_blank"><img src="img/cpasubmit.gif" alt="淘宝网购买链接" /></a></div>
</div>
</div>
</div>

<!-- 赞助商链接 -->
<div class="googlegg">
<div class="ng">
<div class="ngtitle">
<div class="left"><strong>淘宝客<span>推广</span>联盟</strong></div>
<div class="right">赞助商链接：<a href="http://www.7895123.com.cn/" target="_blank">免淘网</a> - 帮您淘宝，购物无忧</div>
</div>
<div id="ListAdsense">
<a href="http://shop57088361.taobao.com/" target="_blank">购时尚服饰</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a><br />
<a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a><br />
<a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a><br />
<a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a><br />
<a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a><br />
<a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a> - <a href="http://www2.im.alisoft.com/webim/tribe/tribeDetail.htm?tribeId=106186486&userId=cntaobao&isSingle=y" target="_blank">虚位以待-赞助商绝佳广告位置</a><br />
</div>
</div>
</div>
<!-- /赞助商链接 -->
</div>

<?php
include("footer.php");
?>
</body>
</html>