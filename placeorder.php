<?php print("<?xml version=\"1.0\" ?>\n"); ?>
<!DOCTYPE vxml PUBLIC "-//BeVocal Inc//VoiceXML 2.0//EN" 
   "http://cafe.bevocal.com/libraries/dtd/vxml2-0-bevocal.dtd">
 
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xml:lang="en-US" >
<form>
<block>
<audio src="audio/ThankYouFiveMinutes.wav"/>
<disconnect />
</block>
</form>
 </vxml>

<?php
$user_id = $_GET["user_id"];
$price_id = $_GET["price_id"];

$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));

$order_insert_query = "INSERT INTO `Order`(`user_pin`, `price_id`, `order_status`) VALUES ('$user_id','$price_id','not-ready')";
$result = $mysqlCon->query($order_insert_query);

if ($result === TRUE) {
    //echo "New record created successfully";
} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
}
$mysqlCon->close();
?>
