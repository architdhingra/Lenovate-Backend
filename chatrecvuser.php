<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['email'])) {
    
	$email = $_POST['email'];
	
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
    $result = mysqli_query("SELECT msg, time, admin FROM messages WHERE email='$email' ORDER BY time DESC limit 20;");
	while($var = mysqli_fetch_row($result)){
		$msg[$i] = $var[0];
		$time[$i] = $var[1];
		$admin[$i] = $var[2];
		$i++;
	}
	$update = mysqli_query("update messages set status='r' where email='$email';");
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		
        $response["message"] = "found";
		$response["msg"] = $msg;
		$response["time"] = $time;
		$response["admin"] = $admin;
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