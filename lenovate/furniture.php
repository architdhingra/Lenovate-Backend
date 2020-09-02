<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
    $result = mysqli_query($db, "select scat,cid, image from category where cat = 'furniture'");
	while($var = mysqli_fetch_row($result)){
		$sc[$i] = $var[0];
		$cid[$i] = $var[1];
		$img[$i] = $var[2];
		$i++;
	}
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		$response["categories"] = $sc;
		$response["subid"] = $cid;
		$response["image"] = $img;
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
 

 

?>