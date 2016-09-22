<?php
header("Content-type:text/html; charset=utf-8");
$con=mysql_connect("localhost","root","root");
if(!$con)
{
	die("Could not connect database:" . mysql_error());
}
mysql_select_db("my_db",$con);
$sql="select * from persons order by Age";
$result=mysql_query($sql);
echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
</tr>";
while ($row=mysql_fetch_array($result)) {
	echo "<tr>";
	echo "<td>" . $row['Firstname'] . "</td>";
	echo "<td>" . $row['Lastname'] . "</td>";
	echo "<td>" . $row['Age'] . "</td>";
	echo "</tr>";	
}
echo "</table>";
mysql_close($con);
?>