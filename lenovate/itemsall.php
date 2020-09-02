<?php

$response = array();

// check for required fields

 if (isset($_POST['lowrange']) && isset($_POST['highrange'])) {
    
	$lowrange = $_POST['lowrange'];
	$highrange = $_POST['highrange'];
    $flag = 0;
	
	// include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
    $result = mysqli_query($db, " select name, price, des, image, id from items ");
	while($var = mysqli_fetch_row($result)){
		$namex[$i] = $var[0];
		$pricex[$i] = $var[1];
		$desx[$i] = $var[2];
		$imagex[$i] = $var[3];
		$idx[$i] = $var[4];
		$i++;
	}
	$k=0;
	if($lowrange>$i){
		$flag=0;
	}
	else{	
		if($highrange>$i){
			$limit = $i;	
		}
		else{
			$limit = $highrange;
		}
		for($j=$lowrange; $j<$limit; $j++){
			$name[$k]=$namex[$j];
			$price[$k]=$pricex[$j];
			$des[$k]=$desx[$j];
			$image[$k]=$imagex[$j];
			$id[$k]=$idx[$j];
			$k++;
			$flag=1;
		}
	}
	// check if row inserted or not
    if ($flag) {
        // successfully inserted into database
        $response["success"] = 1;
		
		$response["itemname"] = $name;
		$response["itemprice"] = $price;
		$response["itemdesc"] = $des;
		$response["itemimg"] = $image;
		$response["itemid"] = $id;
		
		
        $response["message"] = "found";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Invalid Limit";
        
        // echoing JSON response
        echo json_encode($response);
    }
 }
	 else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
 }

?>