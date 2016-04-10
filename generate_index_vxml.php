<?php print("<?xml version=\"1.0\" ?>\n"); ?>
<!DOCTYPE vxml PUBLIC "-//BeVocal Inc//VoiceXML 2.0//EN" 
   "http://cafe.bevocal.com/libraries/dtd/vxml2-0-bevocal.dtd">
   
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml" xml:lang="en-US">
 <!-- <meta name="saif" content="saifulabu25@gmail.com"/> -->

 
 <?php
//data base connection and query					
$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));

//$query_coffee_type = "SELECT `coffee_type_id`,`coffee_type_name` FROM `CoffeeTypes` ";
$query_coffee_type = "SELECT `coffee_type_id`,`coffee_type_name` FROM `CoffeeTypes` ";
$result_coffee_type = $mysqlCon->query($query_coffee_type);

//get coffee size
$query_coffee_size = "SELECT `coffee_size_id`,`coffee_size_name` FROM `CoffeeSize` ";
$result_coffee_size = $mysqlCon->query($query_coffee_size);

//get coffe price
$query_price = "SELECT `price_id`, `coffee_type_id`, `coffee_size_id`, `coffee_price` FROM `Price`";
$result_price = $mysqlCon->query($query_price);					
?>
 
 
 <form>
    <script>
	   <![CDATA[
		var coffee_type_id, coffee_size_id, price_id, price_value;
		var coffeeTypeAudio, coffeeSizeAudio, baseURL;
	   ]]>
	</script>
    <property name="bevocal.voice.name" value="mark"/>
    <block>
       <prompt>
			<audio
				src="audio/welcome.wav">
				Hi, welcome to daniel cafe
			</audio>
		</prompt>
    </block>
    
        
   <field name="user_id" type="digits">
		
			<audio src="audio/whatIsPin.wav" />		
		<nomatch>				
				<audio src="audio/noMatchPin.wav" />								
		</nomatch>
		<noinput>
			<audio src="audio/noMatchPin.wav" maxage="0" maxstale="0" />
		</noinput>
	</field>

    <field name="user_id_conf" type="boolean">
		<prompt>		
			<audio src="audio/PinIs.wav" maxage="0" maxstale="0">
				Your User Id is.
			</audio>
			<value expr="user_id"/>
			
			<audio src="audio/IsThisCorrect.wav" maxage="0" maxstale="0">
				Is this correct?
			</audio>
			
		</prompt>
		
		<nomatch>
			<audio src="audio/PinIs.wav" maxage="0" maxstale="0" />
		</nomatch>
		
		<noinput>
			<audio src="audio/PinIs.wav" maxage="0" maxstale="0" />
		</noinput>
		
        <filled>
            <if cond="user_id_conf==false">
			    <clear namelist="user_id user_id_conf" />
                <goto nextitem="user_id" />
            </if>
        </filled>
	</field>
	
	<field name="coffeetype">
		<prompt>
			<audio src="audio/CoffeeTypeWant.wav" maxage="0" maxstale="0">
				What type of coffee would you like?
			</audio>
		</prompt>
		<nomatch>
			<audio src="audio/NoMatchCoffee.wav"/>
		</nomatch>
		
		<noinput>
			<audio src="audio/NoMatchCoffee.wav"/>
		</noinput>
		<grammar xml:lang="en-us" version="1.0" root="COFFEETYPE" mode="voice">
			<rule id="COFFEETYPE" scope="public">
				<one-of>
					<?php
						if ($result_coffee_type->num_rows > 0) {
						// output data of each row
							while($row = $result_coffee_type->fetch_assoc()) {
								echo "<item>" . $row["coffee_type_name"]. "</item>". "\n";
							}//end while
						}//end if 
					?>
					
				</one-of>
			</rule>
		</grammar>
		<filled>
			<script>
				<![CDATA[
					//var coffee_type_id, coffee_size_id, price_id, price_value;
					<?php
						$result_coffee_type = $mysqlCon->query($query_coffee_type);
											
						if ($result_coffee_type->num_rows > 0) {
						// output data of each row
							$row = $result_coffee_type->fetch_assoc();
							echo "if(coffeetype == '".$row["coffee_type_name"]."'){\n" ;
							echo "coffee_type_id = ". $row["coffee_type_id"]. ";\n}";
							while($row = $result_coffee_type->fetch_assoc()) {
								echo "else if(coffeetype == '" . $row["coffee_type_name"]. "'){\n";
								echo "coffee_type_id = ". $row["coffee_type_id"]. ";\n}"; 
							}//end while
							
						}//end if
						
					?>
				]]>
			</script>
		</filled>
	</field>
 
	<field name="coffeesize">
		<audio src="audio/WhatSizeWouldYouLike.wav">
		
			What will be the size?
		</audio>
		
		<nomatch>
			<audio src="audio/NoInputSize.wav" />
		</nomatch>
			
		<noinput>
			<audio src="audio/NoInputSize.wav" />
		</noinput>
		
		<grammar xml:lang="en-us" version="1.0" root="COFFEESIZE" mode="voice">
			<rule id="COFFEESIZE" scope="public">
				<one-of>
					<?php
						if ($result_coffee_size->num_rows > 0) {
						// output data of each row
							while($row = $result_coffee_size->fetch_assoc()) {
								echo "<item>" . $row["coffee_size_name"]. "</item>". "\n";
							}//end while
						}//end if 
					?>
				</one-of>
			</rule>
		</grammar>
		<filled>
			<script>
				<![CDATA[
					
					<?php
						$result_coffee_size = $mysqlCon->query($query_coffee_size);
											
						if ($result_coffee_size->num_rows > 0) {
							// output data of each row
							$row = $result_coffee_size->fetch_assoc();
							echo "if(coffeesize == '".$row["coffee_size_name"]."'){\n" ;
							echo "coffee_size_id = ". $row["coffee_size_id"]. ";\n}";
							while($row = $result_coffee_size->fetch_assoc()) {
								echo "else if(coffeesize == '" . $row["coffee_size_name"]. "'){\n";
								echo "coffee_size_id = ". $row["coffee_size_id"]. ";\n}"; 
							}//end while							
						}//end if
						
						//price_id`, `coffee_type_id`, `coffee_size_id`, `coffee_price
						if($result_price->num_rows > 0){
							$row = $result_price->fetch_assoc();
							echo "\n if(coffee_type_id == ".$row["coffee_type_id"]." && coffee_size_id == ".$row["coffee_size_id"]."){\n" ;
							echo "price_id = ".$row['price_id'].";\n price_value = ".$row['coffee_price'].";\n}";
							
							while($row = $result_price->fetch_assoc()){
								echo "else if(coffee_type_id == ".$row["coffee_type_id"]." && coffee_size_id == ".$row["coffee_size_id"]."){\n" ;
							echo "price_id = ".$row['price_id'].";\n price_value = ".$row['coffee_price'].";\n}";
							}
						}//end if
						
					?>
					
				]]>
			</script>			
		</filled>
	</field>
	
	<field name="order_confirmation" type="boolean">
	
		
		<prompt>
			<audio src="audio/YouOrdereda.wav"/> 
			<audio expr="'audiocofftypesize/'+ coffeesize.replace(/\s+/g, '') + '.wav'" /> 
			<audio expr="'audiocofftypesize/'+ coffeetype.replace(/\s+/g, '') + '.wav'" /> 
			
			<audio src="audio/TotalPrice.wav"/>
			<value expr="price_value" />. 
			<audio src="audio/Dollars.wav"/>
			
			<audio src="audio/IsThisCorrect.wav"/>
		</prompt>	
		<nomatch>
			<reprompt />
		</nomatch>
		<noinput>
			<reprompt />
		</noinput>
		<filled>
            <if cond="order_confirmation==false">
			    <clear namelist="coffeetype coffeesize order_confirmation" />
                <goto nextitem="coffeetype" />
            </if>
        </filled>
	</field>
 
	<filled>
		<submit next="http://danicafe-saifdaniel.rhcloud.com/placeorder.php" method="get" namelist="user_id price_id" fetchtimeout="20s"/>
	</filled>
</form>
</vxml>
<?php 
 //disconnect
$mysqlCon->close();
 ?>