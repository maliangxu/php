<?php

	require_once("util.php");

	$access_token = getAccessToken();

	$code = $_GET["code"];

	$usrs_url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=$access_token&code=$code";

	$return = httpGet($usrs_url);

	echo $return;

?>