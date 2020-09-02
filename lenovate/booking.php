<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['email']) && isset($_POST['addr'])) {
    
	$itemid = $_POST['id'];
	$tprice = $_POST['tprice'];
	$email = $_POST['email'];
	$addr = $_POST['addr'];
	$qtty = $_POST['qty'];
	$ccaid = $_POST['ccaid'];
	
	$itemids = explode(",",$itemid);
	$qty = explode(",",$qtty);
	
	//echo $itemids;
    $size = sizeof($itemids);
	// include db connect class
    require_once('db_connect2.php');
	
    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$date = date("Y-m-d");
	$time = date("h:i:sa");
	$ctime = $date."  ".$time;
    // mysqli inserting a new row
	
    $result = mysqli_query($db, "INSERT INTO booking (ccaid, addr, tprice, email, ctime) VALUES ('$ccaid', '$addr', '$tprice', '$email', '$ctime')");
	$query  = mysqli_query($db, "SELECT bid FROM booking ORDER BY bid DESC LIMIT 1");
	$getbid = mysqli_fetch_row($query);
	$bid = $getbid[0];
	
	for($i=0;$i<$size;$i++){
		$query2 = mysqli_query($db, "INSERT INTO booking_items (bid, id, qty, sno) VALUES ('$bid', '$itemids[$i]', '$qty[$i]', NULL)");
	}
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		
		$response["bid"] = $bid;

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