<?php

	header("Content-type: text/html; charset=utf-8");
	include "TopSdk.php";
	include "top/TopClient.php";
	date_default_timezone_set('Asia/Shanghai'); 
	
	$c = new TopClient;
	$c->appkey = "23270934";
	$c->secretKey = "89bb710c46c0ff2740ac3419c2e0d6f9";
	$req = new AlibabaAliqinFcSmsNumSendRequest;
	$req->setExtend("123");
	$req->setSmsType("normal");
	$req->setSmsFreeSignName("三林镇建设项目");
	$req->setSmsParam('{"product":"xiaoming","code":"987"}');
	$req->setRecNum("13262208625");
	$req->setSmsTemplateCode("SMS_2570065");
	$resp = $c->execute($req);


?>