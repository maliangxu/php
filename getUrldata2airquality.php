<?php
header("Content-type:text/html;charset=utf-8");
//使得程序能够定时运行
ignore_user_abort(); //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.  
set_time_limit(0); // 执行时间为无限制，php默认执行时间是30秒，可以让程序无限制的执行下去  
$interval=60*60; // 每隔一小时运行一次  
do{  
 
 //利用函数从url获取数据
$json = GetCurl("http://www.pm25.in/api/querys/all_cities.json?token=jzxqS2qpsYU3bRhkEjey"); //这个是json数据文件
var_dump($json[0]['aqi']);

/**********把上述数据插入数据库*******************/
//连接数据库
$con = mysql_connect("localhost","root","");
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
mysql_select_db("airquality_db",$con);

/*插入多条记录时，若循环使用多个insert into语句，要增加服务器的负担，
因为每执行一次SQL服务器都要同样对SQL进行分析、优化等操作，
所以采用insert into values(),(),()...一次性插入。
但由于插入内容重复时，这条语句报错，任何一条记录都不会被插入，
所以，换用replace into
*/
//构造插入sql
$aqi_1 =$json[0]['aqi'];
$co_1 = $json[0]['co'];
$no2_1 = $json[0]['no2'];
$so2_1 = $json[0]['so2'];
$pm2_5_1 = $json[0]['pm2_5'];
$pm10_1 = $json[0]['pm10'];
$primary_pollutant_1 = $json[0]['primary_pollutant'];
$station_code_1 = $json[0]['station_code'];
$o3_1 = $json[0]['o3'];
$time_point_1 = $json[0]['time_point'];
$time_1 = str_replace("T","",$json[0]['time_point']);
$time_1 = str_replace("Z","",$time_1);
$sql = "replace into airquality(aqi,co,no2,so2,pm10,
pm2_5,primary_pollutant,station_code,o3,time_point，time)
values('$aqi_1','$co_1','$no2_1','$so2_1','$pm10_1',
'$pm2_5_1','$primary_pollutant_1','$station_code_1','$o3_1','$time_point_1','$time_1')";
for($i=1;$i<sizeof($json);$i++) 
{   $aqi_1 =$json[$i]['aqi'];
	$co_1 = $json[$i]['co'];
	$no2_1 =$json[$i]['no2'];
	$so2_1 = $json[$i]['so2'];
	$pm2_5_1 = $json[$i]['pm2_5'];
	$pm10_1 = $json[$i]['pm10'];
	$primary_pollutant_1 = $json[$i]['primary_pollutant'];
	$station_code_1 = $json[$i]['station_code'];
	$o3_1 = $json[$i]['o3'];
	$time_point_1 = $json[$i]['time_point'];
	$sql = $sql.",('$aqi_1','$co_1','$no2_1','$so2_1','$pm10_1',
	'$pm2_5_1','$primary_pollutant_1','$station_code_1','$o3_1','$time_point_1','$time_1')";
	
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