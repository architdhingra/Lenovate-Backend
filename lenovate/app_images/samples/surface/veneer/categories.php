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
	$i = 0;
    // mysql inserting a new row
    $result = mysql_query("select distinct(cat), image from category_image where cid<200");
	while($var = mysql_fetch_row($result)){
		$x[$i] = $var[0];
		$xx[$i] = $var[1];
 		$i++;
	}
	
	$qry = mysql_query("select cid, image from banner");
	$i = 0;
	while($cc = mysql_fetch_row($qry)){
		if($cc[0]>200 && $cc[0]<2000){
			$result = mysql_query("select scat from category where cid = '$cc[0]';");
		}
		else{
			$result = mysql_query("select cat from category where cid = '$cc[0]';");
		}
		$var = mysql_fetch_row($result);
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