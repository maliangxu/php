<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
//使得程序能够定时运行
ignore_user_abort(); //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.  
set_time_limit(0); // 执行时间为无限制，php默认执行时间是30秒，可以让程序无限制的执行下去  
$interval=60*60; // 每隔一小时运行一次  

do{  
 
	 //利用函数从url获取数据
	$jsonList = GetCurl("http://api.openweathermap.org/data/2.5/group?id=1796236,1799397,1808926,1799962,1790645&units=metric&APPID=94506fa9256f37bd13eae4126beb7d8d&lang=zh_cn"); 
	//这个是json数据文件
	$json = $jsonList["list"];
	/**********把上述数据插入数据库*******************/
	//连接数据库
	$con = mysql_connect("localhost","root","root");
	if(!$con)
	{
		die("Could not connect:".mysql_error());
	}
	else
	{
		mysql_query("SET NAMES UTF8");//设置交互字符集
		mysql_query("set character_set_client=utf8");
		mysql_query("set character_set_results=utf8");
	}
	//选择数据库
	set_time_limit(0);//设置永远不超时
	mysql_select_db("weather",$con);
	$rain_time="";
	$weather_main=$json[0]["weather"][0]["main"];
	$weather_description=$json[0]["weather"][0]["description"];
	$temp=$json[0]["main"]["temp"];
	$humidity=$json[0]["main"]["humidity"];
	$pressure=$json[0]["main"]["pressure"];
	$wind_speed=$json[0]["wind"]["speed"];
	$wind_deg=$json[0]["wind"]["deg"];
	$rain=$json[0]["rain"];
	foreach ( $json[0]["rain"] as $key=>$val ) { 
		$rain_time=$key;
		$rain=$val;
	}
	$id=$json[0]["id"];
	$name=$json[0]["name"];
	$dt=$json[0]["dt"];
	$time_point=date('Y-m-d H:i:s',$dt);

	$sql = "replace into weather(weather_main,weather_description,temp,humidity,pressure,wind_speed,wind_deg,rain_time,rain,id,name,time_point)values('$weather_main','$weather_description','$temp','$humidity','$pressure','$wind_speed','$wind_deg','$rain_time','$rain','$id','$name','$time_point')";

	for($i=1;$i<sizeof($json);$i++) {
		$rain_time="";
		$weather_main=$json[$i]["weather"][0]["main"];
		$weather_description=$json[$i]["weather"][0]["description"];
		$temp=$json[$i]["main"]["temp"];
		$humidity=$json[$i]["main"]["humidity"];
		$pressure=$json[$i]["main"]["pressure"];
		$wind_speed=$json[$i]["wind"]["speed"];
		$wind_deg=$json[$i]["wind"]["deg"];
		$rain=$json[$i]["rain"];
		foreach ( $json[$i]["rain"] as $key=>$val ) { 
			$rain_time=$key;
			$rain=$val;
		}
		$id=$json[$i]["id"];
		$name=$json[$i]["name"];
		$dt=$json[$i]["dt"];
		$time_point=date('Y-m-d H:i:s',$dt);
		$sql = $sql.",('$weather_main','$weather_description','$temp','$humidity','$pressure','$wind_speed','$wind_deg','$rain_time','$rain','$id','$name','$time_point')";

	}

	if(mysql_query($sql,$con))
		{
			echo "insert success";
		}
	else
		{
			echo mysql_error();
		}
		
	sleep($interval); // 按设置的时间等待一小时循环执行  
	$sql1="update blog set time=now()"; 
}while(true);




	//定义GetCurl()函数，从url获取json文件，并以数组形式返回变量
	function GetCurl($url){
	 set_time_limit(0);//设置永远不超时
	    $curl = curl_init();
	    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//获取url数据作为变量存储，设置为1或true
	    curl_setopt($curl,CURLOPT_URL, $url);
	 //模拟用户使用的浏览器，在HTTP请求中包含一个"user-agent"头的字符串。
	    curl_setopt($curl,CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    $resp = curl_exec($curl);//运行curl，请求网页
	 	$json = json_decode($resp,true);
	    curl_close($curl);//关闭curl请求
	    return $json;
	}




?>