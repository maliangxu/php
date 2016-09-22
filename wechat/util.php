<?php

  header("Access-Control-Allow-Origin: *");
  header("Content-type:application/json;charset=utf-8");

  global $Token_url;

  $Token_url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=wxba565b0cbd1e1e03&corpsecret=tizdDWzlxbsxFS9tBtdmzxaciMlwSS4rxHFG-wJombhyGnkWuRT9p92HRK2Ot7ya";

  function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
  }

  function httpPost($url,$param,$post_file=false){
  	$oCurl = curl_init();
  	if(stripos($url,"https://")!==FALSE){
  		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
  		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
  		curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
  	}
  	if (is_string($param) || $post_file) {
  		$strPOST = $param;
  	} else {
  		$aPOST = array();
  		foreach($param as $key=>$val){
  			$aPOST[] = $key."=".urlencode($val);
  		}
  		$strPOST = join("&", $aPOST);
  	}
  	curl_setopt($oCurl, CURLOPT_URL, $url);
  	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
  	curl_setopt($oCurl, CURLOPT_POST,true);
  	curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
  	$sContent = curl_exec($oCurl);
  	$aStatus = curl_getinfo($oCurl);
  	curl_close($oCurl);
  	if(intval($aStatus["http_code"])==200){
  		return $sContent;
  	}else{
  		return false;
  	}
  }

  function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(get_php_file("access_token.php"));
    if ($data->expire_time < time()) {
    	global $Token_url;
      $res = json_decode(httpGet($Token_url));
      $access_token = $res->access_token;
      $lifeTime = $res->expires_in;
      if ($access_token) {
        $data->expire_time = time() + $lifeTime;
        $data->access_token = $access_token;
        set_php_file("access_token.php", json_encode($data));
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  function encode_json($str){  
    $code = json_encode($str);  
    return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);  
  }

  function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
  }

  function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
  }


?>