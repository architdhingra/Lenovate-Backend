<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// array for JSON response
$response = array();

    
    // include db connect class
    require_once('db_connect2.php');
	
    // connecting to db
            $db = new DB_CONNECT(); 
	$db = $db->connect();
	$i = 0;
	
	// mysqli inserting a new row
    $result = mysqli_query($db, "select distinct(category_image.cat), category_image.image from category_image, category where cid<200 and category.cat=category_image.cat");

	while($var = mysqli_fetch_row($result)){
		$x[$i] = $var[0];
		$xx[$i] = $var[1];
 		$i++;
	}
	
	$qry = mysqli_query($db, "select cid, image from banner");
	$i = 0;
	while($cc = mysqli_fetch_row($qry)){
		if($cc[0]>200 && $cc[0]<2000){
			$result = mysqli_query($db, "select scat from category where cid = '$cc[0]';");
		}
		else{
			$result = mysqli_query($db, "select cat from category where cid = '$cc[0]';");
		}
		$var = mysqli_fetch_row($result);
		$scat[$i] = $var[0];
		$image[$i] = $cc[1];
		$cid[$i] = $cc[0];
		$i++;
	}
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		$response["categories"] = $x;
		$response["image"] = $xx;
        $response["bannerimage"] = $image;
		$response["scat"] = $scat;
		$response["scid"] = $cid;
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