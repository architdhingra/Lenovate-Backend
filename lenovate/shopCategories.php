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
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
    $result = mysqli_query($db, "select distinct(cat) from category where cid>2000");
	while($var = mysqli_fetch_row($result)){
		$x[$i] = $var[0];
		$nextresult = mysqli_query($db, "select image from category_image where cat = '$x[$i]'");
		$kchb = mysqli_fetch_row($nextresult);
		$xx[$i] = $kchb[0];
 		$i++;
	}
	
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		$response["categories"] = $x;
		$response["image"] = $xx;
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