<?php

  require_once("util.php");

  $access_token = getAccessToken();

  $msg_url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$access_token";
	
  $usrs = json_decode(stripslashes($_GET["usrs"]));

  $usrs_count = count($usrs);

  $url = $_GET["url"];

  $redirect_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxba565b0cbd1e1e03&redirect_uri=$url&response_type=code&scope=snsapi_base#wechat_redirect";

  $title = $_GET["title"];

  $description = $_GET["description"];

  $usrstr = "";

  for($i = 0; $i < $usrs_count; $i++){
    $usrstr .= $usrs[$i]."|";
  }

  $news = array(
  	"touser" => $usrstr,
    "agentid" => "4",
    "msgtype" => "news",
    "news" => array(
      "articles" => array(array(
        "title" => $title,
        "description" => $description,
        "url" => $redirect_url,
      ))
    )
  );

  $data = encode_json($news);

  $return = httpPost($msg_url,$data,$post_file=false);

  echo $return;


?>