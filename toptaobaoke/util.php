<?php
require_once 'config.php';
//签名函数 
function createSign ($paramArr) { 
    global $appSecret; 
    $sign = $appSecret; 
    ksort($paramArr); 
    foreach ($paramArr as $key => $val) { 
       if ($key !='' && $val !='') { 
           $sign .= $key.$val; 
       } 
    } 
    $sign = strtoupper(md5($sign)); 
    return $sign; 
}

//组参函数 
function createStrParam ($paramArr) { 
    $strParam = ''; 
    foreach ($paramArr as $key => $val) { 
       if ($key != '' && $val !='') { 
           $strParam .= $key.'='.urlencode($val).'&'; 
       } 
    } 
    return $strParam; 
} 

//解析xml函数
function getXmlData ($strXml) {
	$pos = strpos($strXml, 'xml');
	if ($pos) {
		$xmlCode=simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
		$arrayCode=get_object_vars_final($xmlCode);
		return $arrayCode ;
	} else {
		return '';
	}
}
	
function get_object_vars_final($obj){
	if(is_object($obj)){
		$obj=get_object_vars($obj);
	}
	if(is_array($obj)){
		foreach ($obj as $key=>$value){
			$obj[$key]=get_object_vars_final($value);
		}
	}
	return $obj;
}
?>