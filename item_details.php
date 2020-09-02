<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['itemid'])) {
    
	$scid = $_POST['itemid'];
	$email = $_POST['email'];
	
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
    // mysqli inserting a new row
    $result = mysqli_query($db, "select name, price, des, image from items where id = '$scid'");
	while($var = mysqli_fetch_row($result)){
		$name = $var[0];
		$price = $var[1];
		$des = $var[2];
		$image = $var[3];
	}
	
	$noteqry = mysqli_query($db, "select note from collection where email = '$email' and itemid = '$scid' ");
	$v = mysqli_fetch_row($noteqry);
	$note = $v[0];
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		
		$response["itemname"] = $name;
		$response["itemprice"] = $price;
		$response["itemdesc"] = $des;
		$response["itemimg"] = $image;
		$response["itemnote"] = $note;
		
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