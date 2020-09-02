
<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();
// check for required fields
if (isset($_POST['uname']) && isset($_POST['pname'])) {
    
    $uname = $_POST['uname'];
    $pname = $_POST['pname'];
    if($pname==null){$pname="bh";}
    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();
	$query = mysqli_query($db, "select number from users where email = '$uname' ");
	$answer = mysqli_fetch_row($query);
	$number = $answer[0];
    $qry = "select pwd from users where number = '".$uname."'";
	
    $cd = mysqli_query($db, $qry);
	
	$ab = mysqli_fetch_row($cd);
	$result = $ab[0];

    // check if row inserted or not
    if ($result == $pname) {
        // successfull details
        
        $response["success"] = 1;
        $response["message"] = "Logged In";
		$response["number"] = $number;
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Invalid! Loser.";
        
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>
