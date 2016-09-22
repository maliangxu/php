<?php
header("content-type:text/html; charset=utf-8");
$con=mysql_connect("localhost","root","root");
if(!$con)
{
	die("Could not connect database:" . mysql_error());
}
mysql_select_db("my_db",$con);
$sql="insert into persons(Firstname,Lastname,Age)
	values('$_POST[firstname]','$_POST[lastname]','$_POST[age]')";
// mysql_query("insert into persons(firstname,lastname,age)
// 	value('Li','Yanhong','46')");
if($_POST[firstname]==null||$_POST[lastname]==null||$_POST[age]==null)
{
	echo '<script>alert("记录没有填写完整！");</script>';
}
else
{
	if(!mysql_query($sql,$con))
	{
		die("Error:" . mysql_error());
	}
	echo '<script>alert("插入成功！");</script>';
}
	

mysql_close($con);
?>