<?php
header("Content-type:text/html; charset=utf-8");
$con=mysql_connect("localhost","root","root");
if(!$con)
{
	die('Could not connect:' . mysql_error());
}

//Create database
if(mysql_query("create database my_db",$con))
{
	echo "Database created";
}
else
{
	echo "Error creating database:" . mysql_error();
}

//Create table in my_db
mysql_select_db("my_db",$con);
$sql="Create table persons
(
	Firstname varchar(15),
	Lastname varchar(15),
	Age int
)";
mysql_query($sql,$con);

mysql_close($con);
?>