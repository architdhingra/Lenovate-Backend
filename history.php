<?php

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['email'])) {
    
    $email = $_POST['email'];
  require_once('db_connect2.php');
  $i = 0;
  $j = 0;
    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
  
  
  $secondquery = mysqli_query($db, "select tprice, bid, ctime from users, booking where users.email = booking.email and booking.email = '$email' order by ctime desc;");
  while($second = mysqli_fetch_row($secondquery)){
  
  $tprice[$i] = $second[0];
  $bid[$i] = $second[1];
  $bdate[$i] = $second[2];
  /*$thirdquery = mysqli_query($db, "select name, items.id from items, booking_items where bid = '$bid[$i]' and items.id = booking_items.id;");
  while($third = mysqli_fetch_row($thirdquery)){
    $items[$i] = $items[$i].", ".$third[0];
    $id[$i] = $third[1];
  }*/
  $i++;
  }
  
  
  if ($secondquery) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Successful";
    //$services = str_replace(array("\r","\n",'\r','\n'),'', $services);
    //$sname = str_replace(array("\r","\n",'\r','\n'),'', $sname);
    $response["bid"] = $bid;
    $response["bdate"] = $bdate;
    $response["tprice"] = $tprice;
    
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