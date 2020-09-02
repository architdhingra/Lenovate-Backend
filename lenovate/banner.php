<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); 
	$db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
    $result = mysqli_query($db, "select scat, banner.image from banner, category where category.cid = banner.cid;");
	while($var = mysqli_fetch_row($result)){
		$scat[$i] = $var[0];
		$image[$i] = $var[1];
		$i++;
	}
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		$response["image"] = $image;
		$response["scat"] = $scat;
	    $response["message"] = "done";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
        
        // echoing JSON response
        echo json_encode($response);
    }

?>