<?php
header("content-type:text/html; charset=UTF-8");
$con=mysql_connect("localhost","root","root");
if(!$con)
{
	die("Could not connect database:" . mysql_error());
}
mysql_select_db("my_db",$con);
$sql="delete from persons where Firstname='$_POST[Firstname]'";
if(!mysql_query($sql,$con))
{
	die("Error:" . mysql_error());
}
else
{
	echo '<script>alert("删除成功！");</script>';
}

mysql_close();
?>