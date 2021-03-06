<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['cat'])) {
    
	$sname = $_POST['cat'];
	
	$color = $_POST['color'];
	$style = $_POST['style'];
	$material = $_POST['material'];
	$room = $_POST['room'];
	
    // include db connect class
    require_once('db_connect2.php');
	
    // connecting to db
    $db = new DB_CONNECT();
	$db = $db->connect();	
	$i = 0;
	$n = 0;
	$filter;
    // mysqli inserting a new row
    $result = mysqli_query($db, "select name, price, des, items.image,id from items, category where items.cid = category.cid and scat = '$sname' and colour like '%$color%' and style like '%$style%' and material like '%$material%' and room like '%$room%'");
	while($var = mysqli_fetch_row($result)){
		$name[$i] = $var[0];
		$price[$i] = $var[1];
		$des[$i] = $var[2];
		$image[$i] = $var[3];
		$id[$i] = $var[4];
		$i++;
	}
	$filterqry = mysqli_query($db, "SELECT distinct(colour) FROM items, category where items.cid = category.cid and colour !=('') and scat = '$sname'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "color";
			$n++;
		}
		$color_options[$k] = $var[0];
		$k++;
	}
	
	$filterqry = mysqli_query($db, "SELECT distinct(style) FROM items, category where items.cid = category.cid and style !=('') and scat = '$sname'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "style";
			$n++;
		}
		$style_options[$k] = $var[0];
		$k++;
	}
	
	$filterqry = mysqli_query($db, "SELECT distinct(room) FROM items, category where items.cid = category.cid and room !=('') and scat = '$sname'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "room";
			$n++;
		}
		$room_options[$k] = $var[0];
		$k++;
	}
	
	$filterqry = mysqli_query($db, "SELECT distinct(material) FROM items, category where items.cid = category.cid and material !=('') and scat = '$sname'");
	$k = 0;
	while($var = mysqli_fetch_row($filterqry)){
		if($k == 0){
			$filter[$n] = "material";
			$n++;
		}
		$material_options[$k] = $var[0];
		$k++;
	}
	
	$z = 0;
	$categoryqry = mysqli_query($db, "select cat from category where scat = '$sname'");
	$filter[$n] = "category";
	$category = mysqli_fetch_row($categoryqry);
	$subcatqry = mysqli_query($db, "select scat from category where cat = '$category[0]'");
	while($subcat = mysqli_fetch_row($subcatqry)){
		$sub[$z] = $subcat[0];
		$z++;
	}
	
	// check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
		
		$response["subcategories"] = $name;
		$response["itemprice"] = $price;
		$response["itemdesc"] = $des;
		$response["image"] = $image;
		$response["subid"] = $id;
		$response["filter"] = $filter;
		$response["color_options"] = $color_options;
		$response["style_options"] = $style_options;
		$response["room_options"] = $room_options;
		$response["material_options"] = $material_options;
		$response["category_options"] = $sub;
		
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