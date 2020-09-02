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
    $result = mysqli_query($db, "select msg, time, admin from messages where email = '$email'");
	while($var = mysqli_fetch_row($result)){
		$xs[$i] = $var[0];
		$times[$i] = $var[1];
		$types[$i] = $var[2];
		$i++;
	}
	$x = array_reverse($xs);
	$time = array_reverse($times);
	$type = array_reverse($types);
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		$response["msg"] = $x;
		$response["time"] = $time;
		$response["type"] = $type;
		
        $response["message"] = "found";

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