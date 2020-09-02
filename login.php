
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
	$query = mysqli_query($db, "select email from users where email = '$uname' ");
	$answer = mysqli_fetch_row($query);
	if(!$answer){
		$result = 'p';
		$message = "Email Does Not Exist.";
	}
	else{
		$qry = "select pwd from users where email = '".$uname."'";
	
		$cd = mysqli_query($db, $qry);
	
		$ab = mysqli_fetch_row($cd);
		$result = $ab[0];
		
		$nameqry = "select name, number from users where email = '".$uname."'";
		$cd1 = mysqli_query($db, $nameqry);
	
		$ab1 = mysqli_fetch_row($cd1);
		$naam = $ab1[0];
		$number = $ab1[1];
		if ($result == $pname) {
			$message = "Logged in.";
		}
		else{
			$message = "Invalid Password.";
		}
	}
	
    
    // check if row inserted or not
    if ($result == $pname) {
        // successfull details
        
        $response["success"] = 1;
        $response["message"] = $message;
		$response["usernumber"] = $number;
		$response["username"] = $naam;
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = $message;
        
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
