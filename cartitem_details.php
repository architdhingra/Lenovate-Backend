<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['itemid'])) {
    
	$stid = $_POST['itemid'];
	$scid = explode(",",$stid);
	$l =  count($scid);
	
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
	$z = 0;
	foreach($scid as &$x){
		$checkSampleQuery = mysqli_query($db, "select cid from items where id = '$x'");
		$checkSample = mysqli_fetch_row($checkSampleQuery);
		if($checkSample[0]<200){
			$sampleArray[$z] = $checkSample[0];
			$z++;
			$getSampleIdsQuery = mysqli_query($db, "select id from items where cid = $checkSample[0]");
			$t = 0;
			while($abc = mysqli_fetch_row($getSampleIdsQuery)){
				$removeIds[$t] = $abc[0];
				$indexToRemove = array_search($removeIds[$t], $scid);
				$t++;
			}
			$scid = array_merge(array_diff($scid, $removeIds));
		}
	}
	foreach($scid as $x){
		$result = mysqli_query($db, "select name, price, des, image, cid from items where id = '$x'");
		while($var = mysqli_fetch_row($result)){
			$name[$i] = $var[0];
			$des[$i] = $var[2];
			$image[$i] = $var[3];
			if($var[4]<200){
				$price[$i] = "-";
				$type[$i] = "sample";
			}
			else{
				$type[$i] = "product";
				$price[$i] = $var[1];
			}
			$i++;
		}
	}
	
	foreach($sampleArray as $q){
		$singleNameQuery = mysqli_query($db, "select scat, image from category where cid = '$q'");
		while($var = mysqli_fetch_row($singleNameQuery)){
			$name[$i] = $var[0];
			$des[$i] = "sample";
			$image[$i] = $var[1];
			$price[$i] = "-";
			$type[$i] = "sample";
			$i++;
		}
	}
	
	// check if row inserted or not
    if ($checkSampleQuery) {
        // successfully inserted into database
        $response["success"] = 1;
		
		$response["itemname"] = $name;
		$response["itemprice"] = $price;
		$response["itemdesc"] = $des;
		$response["itemimg"] = $image;
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