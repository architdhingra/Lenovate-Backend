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
    $result = mysqli_query($db, "select name, price, des, image, id, note from items, collection where id = itemid and email = '$email'");
	while($var = mysqli_fetch_row($result)){
		$name[$i] = $var[0];
		$price[$i] = $var[1];
		$des[$i] = $var[2];
		$image[$i] = $var[3];
		$id[$i] = $var[4];
		$note[$i] = $var[5];
		$i++;
	}
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		
		$response["itemname"] = $name;
		$response["itemprice"] = $price;
		$response["itemdesc"] = $des;
		$response["itemimg"] = $image;
		$response["itemid"] = $id;
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