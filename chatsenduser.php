<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['email']) && isset($_POST['msg']) && isset($_POST['admin'])) {
    
	$email = $_POST['email'];
	$msg = $_POST['msg'];
	$admin = $_POST['admin'];
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
	if($admin=='n'){
		$result = mysqli_query($db, "INSERT INTO messages (email, time, msg, status, admin) VALUES ('$email', addtime(CURRENT_TIMESTAMP, '0 10:30:00.00'), '$msg', 'u', 'n');");
	}
	else{
		$result = mysqli_query($db, "INSERT INTO messages (email, time, msg, status, admin) VALUES ('$email', addtime(CURRENT_TIMESTAMP, '0 10:30:00.00'), '$msg', 'u', 'y');");
	}
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		
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