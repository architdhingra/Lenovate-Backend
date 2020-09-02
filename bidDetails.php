<?php

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['bid'])) {
    
    $bid = $_POST['bid'];
	require_once('db_connect2.php');
	$i = 0;
	
    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$db = $db->connect();
	
	$thirdquery = mysqli_query($db, "select users.number, users.email, items.name, qty, items.cid, tprice, items.price, booking.addr from items, users, booking, booking_items where booking_items.bid = '$bid' and items.id = booking_items.id and users.email=booking.email and booking.bid = booking_items.bid;");
	while($third = mysqli_fetch_row($thirdquery)){
		$number[$i] = $third[0];
		$email[$i] = $third[1];
		$items[$i] = $third[2];
		$qty[$i] = $third[3];
		$tprice[$i] = $third[5];
		$price[$i] = $third[6];
		$addr[$i] = $third[7];
		if($third[4] <200 ){
			$type[$i] = "sample";
		}
		else{
			$type[$i] = "product";
		}
		$i++;
	}
	
	
	
	if ($thirdquery) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Successful";
		$response["number"] = $number;
		$response["email"] = $email;
		$response["items"] = $items;
		$response["qty"] = $qty;
		$response["type"] = $type;
		$response["addr"] = $addr;
		$response["price"] = $price;
		$response["tprice"] = $tprice;
		
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
        
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