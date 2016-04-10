<?php

$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));

$sql = "SELECT `user_id` FROM `User`";
$result = $mysqlCon->query($sql);
$pin = 10 + mysqli_num_rows($result);
$name = $_GET['Name'];
$credit_card = intval($_GET['CreditCard']);
$mail_addr = $_GET['Email'];

$sql = "INSERT INTO `User`(`pin`, `name`, `credit_card_number`, `mail_address`) VALUES ('$pin', '$name', '$credit_card', '$mail_addr')";
$mysqlCon->query($sql);
echo "Welcome !<br />";
echo $name." your user id is ". $pin . "<br />";
$mysqlCon->close();

?>