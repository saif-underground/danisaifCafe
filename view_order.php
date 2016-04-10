<?php

$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));

$sql = "SELECT * FROM `Order` WHERE `user_pin` in (SELECT `pin` FROM `User`)";
$result = $mysqlCon->query($sql);
$totalOrders = mysqli_num_rows($result);
echo "Total Orders : ".$totalOrders."<br />";

if ($result->num_rows > 0) {
	echo "User PIN\tMenu Item<br />";
	while($row = $result->fetch_assoc()){
		echo $row["user_pin"]."---------".$row['price_id']."<br />";
	}//end while
}//end if

$mysqlCon->close();
?>