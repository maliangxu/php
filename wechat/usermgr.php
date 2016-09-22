<?php
	
	require_once("util.php");

	$access_token = getAccessToken();

	if (isset($_GET["method"])) {
		$method = $_GET["method"];
	} else {
		$method = $_POST["method"];
	}
	
	switch ($method) {
		case "get":
     		$userID = $_GET["userID"];
			$usr_url = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&userid=$userID";
			$return = httpGet($usr_url);
			echo $return;
      	break; 
		case "create":
			$userInfo = $_POST["userInfo"];
			$data = encode_json($userInfo);
			$usr_url = "https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=$access_token";
			$return = httpPost($usr_url, $data);
			echo $return;
		break;
		case "update":
			$userInfo = $_POST["userInfo"];
			$data = encode_json($userInfo);
			$usr_url = "https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=$access_token";
			$return = httpPost($usr_url, $data);
			echo $return;
		break;
		case "delete":
			$userID = $_GET["userID"];
			$usr_url = "https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=$access_token&userid=$userID";
			$return = httpGet($usr_url);
			echo $return;
		break;
		case "batchdelete":
			$userlist = $_POST["userlist"];
			$params = array("useridlist" => $userlist);
			$data = encode_json($params);
			$usr_url = "https://qyapi.weixin.qq.com/cgi-bin/user/batchdelete?access_token=$access_token";
			$return = httpPost($usr_url, $data);
			echo $return;
		break;
	}

?>