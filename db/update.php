<?php
header("content-type:text/html; charset=utf-8");
$con=mysql_connect("localhost","root","root");
if(!$con)
{
	die("Could not connect database:" . mysql_error());
}
mysql_select_db("my_db",$con);
$sql="update persons set Firstname='$_POST[newValue]' where Firstname='$_POST[oldValue]'";
if(!mysql_query($sql,$con))
{
	die("Error:" . mysql_error());
}
else
{
	echo '<script>alert("更新成功！");</script>';
}

mysql_close();
?>