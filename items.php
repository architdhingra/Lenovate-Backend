<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['subid'])) {
    
	$scid = $_POST['subid'];
	
	$color = $_POST['color'];
	$style = $_POST['style'];
	$material = $_POST['material'];
	$room = $_POST['room'];
	$pricefilt = $_POST['price'];
	$qqq = explode("-",$pricefilt);
	
	if(empty($pricefilt)){
		$lp=0;
		$hp=20000;
	}
	else{
		$lp = $qqq[0];
		$hp = $qqq[1];
	}
	
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$i = 0;
	$n = 0;
	$filter;
	
    // mysqli inserting a new row
    $result = mysqli_query($db, "select name,price,des,image,id from items where cid = '$scid' and colour like '%$color%' and style like '%$style%' and material like '%$material%' and room like '%$room%' and price between $lp and $hp");
	while($var = mysqli_fetch_row($result)){
		$name[$i] = $var[0];
		$price[$i] = $var[1];
		$des[$i] = $var[2];
		$image[$i] = $var[3];
		$id[$i] = $var[4];
		$i++;
	}
	
	
	$filterqry = mysqli_query($db, "SELECT distinct(colour) FROM items where colour !=('') and cid = '$scid'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "color";
			$n++;
		}
		$color_options[$k] = $var[0];
		$k++;
	}
	
	$filterqry = mysqli_query($db, "SELECT distinct(style) FROM items where style !=('') and cid = '$scid'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "style";
			$n++;
		}
		$style_options[$k] = $var[0];
		$k++;
	}
	
	$filterqry = mysqli_query($db, "SELECT distinct(room) FROM items where room !=('') and cid = '$scid'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "room";
			$n++;
		}
		$room_options[$k] = $var[0];
		$k++;
	}
	
	$filterqry = mysqli_query($db, "SELECT distinct(material) FROM items where material !=('') and cid = '$scid'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "material";
			$n++;
		}
		$material_options[$k] = $var[0];
		$k++;
	}
	
	$catnameqry = mysqli_query($db, "select cat from category where cid = '$scid';");
	$catname = mysqli_fetch_row($catnameqry);
	$catqry = mysqli_query($db, "select scat, cid from category where cid>2000 and cid!='$scid' and cat = '$catname[0]';");
	$k = 0;
	while($var = mysqli_fetch_row($catqry)){
		if($k == 0){
			$filter[$n] = "category";
			$n++;
		}
		$category_options[$k] = $var[0];
		$categoryid_options[$k] = $var[1];
		$k++;
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
		$response["filter"] = $filter;
		$response["color_options"] = $color_options;
		$response["style_options"] = $style_options;
		$response["room_options"] = $room_options;
		$response["material_options"] = $material_options;
		$response["category_options"] = $category_options;
		$response["categoryid_options"] = $categoryid_options;
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