<?php
error_reporting(0);
require_once 'util.php';
$catid = empty($_GET['catid'])?'0':intval($_GET['catid']);
$page = empty($_GET['page'])?'0':intval($_GET['page']);

//参数数组
$paramArr = array(
    'app_key' => $appKey, 
    'method' => 'taobao.itemcats.get.v2', 
    'format' => 'xml', 
    'v' => '1.0', 
    'timestamp' => date('Y-m-d H:i:s'), 
	'fields' => 'cid,name',
    'parent_cid' => $catid,
	
);

//生成签名
$sign = createSign($paramArr);

//组织参数
$strParam = createStrParam($paramArr);
$strParam .= 'sign='.$sign;

//访问服务
$url = 'http://gw.api.taobao.com/router/rest?'.$strParam;
$result = file_get_contents($url);
$result1 = getXmlData($result);
$result1 = $result1['item_cat'];

//参数数组
$paramArr = array(
    'app_key' => $appKey, 
    'method' => 'taobao.taobaoke.items.get', 
    'format' => 'xml', 
    'v' => '1.0', 
    'timestamp' => date('Y-m-d H:i:s'),
    'fields' => 'iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num',
    'nick' => $usernick,
    'cid' => $catid,
    //信用筛选，关键词搜索筛选，地区筛选，情况wiki文档中的参数。http://wiki.open.taobao.com/index.php/Taobao.taobaoke.items.get
    //'start_credit' => $start_credit,
    //'end_credit' => $end_credit,
	'page_no' => $page,
	'page_size' => '20',
	
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
$taobaokeItem = $result['taobaokeItem'];
$totalResults = $result['totalResults'];
?>

<?php
include("header.php");
?>
<div class="listcontent">
<div class="nav"><a href="./">首页</a> &gt; <a href="category.php">所有分类</a> 
<?php
$ccc=$_GET['catid'];

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
<div class="listcnttitle">当前 <span style="color:#FF3300;"><?php
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
?></span> 类目下共有<span style="color:#0065ff"><?php echo $totalResults;?></span>个商品  </div>
<div class="tbmjcont">
<ul>

<?php
foreach ($result1 as $mtwlist){
	echo "<li><a href=\"category.php?catid=".$mtwlist['cid']."\">".$mtwlist['name']."</a></li>";
	}
?>

</ul>
</div>
</div>
<div class="listallbt"><div class="listallblf"></div><div class="listallbrt"></div></div>
</div>
<!-- /分类 -->

<!-- 列表 -->
<div class="liebtt"><div class="lftt"><div class="lfttl">商品信息</div></div><div class="rttt"></div>
</div><div class="liebline">
<!-- 分页 -->
<div class="pager">
<div class="left">共 <?=ceil($totalResults/20)?> 页/<?=$totalResults?> 条信息</div>
<div class="right">
<span id="lblPager">
<?php   
require_once("SubPages.php");   
//每页显示的条数   
  $page_size=20;   
//总条目数   
  $nums=$totalResults;   
//每次显示的页数   
  $sub_pages=10;   
//得到当前是第几页   
  $pageCurrent=$_GET["page"];   
  //if(!$pageCurrent) $pageCurrent=1;   
     
  $subPages=new SubPages($page_size,$nums,$pageCurrent,$sub_pages,"category.php?catid=".$catid."&page=",2);   
?>
</span>
</div>
</div>
<!--/分页 -->
</div>
<!-- 列表内容 -->
<div class="liebcont">
<div class="liebcttt">
<div class="liebcttt01">商品推广信息</div>
<div class="liebcttt02"><span>单价</span></div>
<div class="liebcttt03"><span>佣金比例</span></div>
<div class="liebcttt04"><span>佣金金额</span></div>
<div class="liebcttt07"><span>成交总量</span></div>
<div class="liebcttt05"><span>购买</span></div>
</div>
<?php
foreach ($taobaokeItem as $mtwitem) {
header('Content-type: text/html; charset=utf-8');
echo "
<div class=\"liebcp\">
<div class=\"liebsm01\"><a href=\"goods.php?nick=".urlencode($mtwitem['nick'])."&aid=".$mtwitem['iid']."\" target=\"_blank\"><img src=\"".$mtwitem['pic_url']."_sum.jpg\" alt=\"".$mtwitem['title']."\" width=\"80\" height=\"80\" /></a></div>
<div class=\"liebsm02\">
<div class=\"picname\"><a href=\"goods.php?nick=".urlencode($mtwitem['nick'])."&aid=".$mtwitem['iid']."\" target=\"_blank\">".$mtwitem['title']."</a></div>
<div class=\"picnmb\">掌柜:".$mtwitem['nick']." <a href=\"shopurl.php?aid=".urlencode($mtwitem['nick'])."\" target=\"_blank\">&raquo;访问淘宝店铺</a></div>
</div>
<div class=\"liebsm03\">".$mtwitem['price']." 元</div>
<div class=\"liebsm04\"><span>".($mtwitem['commission_rate']/100)." %</span></div>
<div class=\"liebsm05\"><span>".$mtwitem['commission']."</span> 元</div>
<div class=\"liebsm07\"><span>".$mtwitem['commission_num']."</span> 件</div>
<div class=\"liebsm06\"><a href=\"goods.php?nick=".urlencode($mtwitem['nick'])."&aid=".$mtwitem['iid']."\" target=\"_blank\"><img src=\"http://taoke.alimama.com/images/cps/fgetccode_btn.gif\" /></a></div>
</div>";
}
?>
</div>
<!-- /列表内容 -->
<div class="liebline">
<!-- 分页 -->
<div class="pager">
<div class="left">共 <?=ceil($totalResults/20)?> 页/<?=$totalResults?> 条信息</div>
<div class="right">
<span id="lblPager">
<?php   
require_once("SubPages.php");   
//每页显示的条数   
  $page_size=20;   
//总条目数   
  $nums=$totalResults;   
//每次显示的页数   
  $sub_pages=10;   
//得到当前是第几页   
  $pageCurrent=$_GET["page"];   
  //if(!$pageCurrent) $pageCurrent=1;   
     
  $subPages=new SubPages($page_size,$nums,$pageCurrent,$sub_pages,"category.php?catid=".$catid."&page=",2);   
?>
</span>
</div>
</div>
<!--/分页 -->
</div>
<!-- /列表 -->
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