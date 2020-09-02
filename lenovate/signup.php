
<?php

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['number']) && isset($_POST['address'])) {
    
    $name = $_POST['name'];
    $password = $_POST['password'];
	if($password==null){$password="g+";}
    $email = $_POST['email'];
	$address = $_POST['address'];
	$number = $_POST['number'];
	$date = date("Y-m-d");

    // include db connect class
    require_once('db_connect2.php');

    // connecting to db
            $db = new DB_CONNECT(); $db = $db->connect();

    // mysqli inserting a new row
    $result = mysqli_query($db, "INSERT INTO users( name, email, cdate, number, pwd, addr) VALUES( '$name','$email', '$date', $number, '$password', '$address')");
	
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "User successfully Registered.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Email or Number already exists.";
        
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