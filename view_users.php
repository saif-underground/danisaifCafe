<?php

$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));

$sql = "SELECT * FROM `User`";
$result = $mysqlCon->query($sql);
$totalUsers = mysqli_num_rows($result);
echo "Total Users : ".$totalUsers."<br />";

if ($result->num_rows > 0) {
	echo "UserPIN\tUserName<br />";
	while($row = $result->fetch_assoc()){
		echo $row['pin']."---------".$row["name"]."<br />";
	}//end while
}//end if

$mysqlCon->close();
?>