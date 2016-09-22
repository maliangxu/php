<?php

	header("Content-type: text/html; charset=utf-8");
	include "TopSdk.php";
	include "top/TopClient.php";
	date_default_timezone_set('Asia/Shanghai'); 
	
	$callback = isset($_GET['callback']) ? trim($_GET['callback']) : '';
	$name = isset($_GET['name']) ? trim($_GET['name']) : 'mm';
	$con = isset($_GET['con']) ? trim($_GET['con']) : 'wuuu';
	$mobile_num = isset($_GET['mobile_num']) ? trim($_GET['mobile_num']) : '13262208625';

	$c = new TopClient;
	$c->appkey = "23270857";
	$c->secretKey = "f85fe907ed07e8c53520fef086cfa1aa";
	$req = new OpenSmsSendmsgRequest;
	$send_message_request = new SendMessageRequest;
	$send_message_request->template_id="879";
	$send_message_request->signature_id="795";
	$send_message_request->context=json_decode("{\"name\":\"".$name."\",\"con\":\"".$con."\"}");
	$send_message_request->mobile=$mobile_num;

	$req->setSendMessageRequest(json_encode($send_message_request));
	$resp = $c->execute($req);

	$date = 'success';
	$tmp= json_encode($date); //json 数据
	echo $callback . '(' . $tmp .')';  //返回格式，必需
?>