<?php

/*
 * Following code will Email admin, the query submitted by the user
 */
require 'phpmailer/PHPMailerAutoload.php';

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['name']) && isset($_POST["email"]) && isset($_POST["msg"])) {
    
  $email = $_POST['email'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  $sth = rand(200,1000);
  $note = 'LNV'.$sth;
  
  $body1 = '<b>Name: '.$name. '<b><br><br><br>Message: '.$msg.'<br><br><b>Email: '.$email.'</b><br><br><br>';
  
  
      $mailowner = new PHPMailer;
      $mailowner->isSMTP();
      //$mail->SMTPDebug = 2;
      $mailowner->Debugoutput = 'html';
      $mailowner->Host = 'smtp.gmail.com';
      $mailowner->Port = 587;
      $mailowner->SMTPSecure = 'tls';
      $mailowner->SMTPAuth = true;
      $mailowner->Username = "lenovateindia@gmail.com";
      $mailowner->Password = "#3llo1234";
      $mailowner->setFrom($email, $name);
      $mailowner->addReplyTo($email, $name);
      $mailowner->addAddress('lenovateindia@gmail.com', 'Lenovate');
      $mailowner->isHTML(true);
      $mailowner->Subject = $name.' Wants to get In Touch';
      $mailowner->Body = $body1;
  
  
      /*------------------------ customer copy --------------------------------------*/
      $body2 = '<b>Your request has been recorded with message: </b><br><br> '.$msg.'<br><br><br><br><b>Thank you for getting in touch, We will get back to you shortly!!</b>';
          
      $mailcustomer = new PHPMailer;
      $mailcustomer->isSMTP();
      //$mail->SMTPDebug = 2;
      $mailcustomer->Debugoutput = 'html';
      $mailcustomer->Host = 'smtp.gmail.com';
      $mailcustomer->Port = 587;
      $mailcustomer->SMTPSecure = 'tls';
      $mailcustomer->SMTPAuth = true;
      $mailcustomer->Username = "lenovateindia@gmail.com";
      $mailcustomer->Password = "#3llo1234";
      $mailcustomer->setFrom('lenovateindia@gmail.com', 'Lenovate');
      $mailcustomer->addReplyTo('lenovateindia@gmail.com', 'Lenovate');
      $mailcustomer->addAddress($email,$name);
      $mailcustomer->isHTML(true);
      $mailcustomer->Subject = 'Requested to get in touch with Lenovate';
      $mailcustomer->Body = $body2;
  
  
  if ($mailowner->send()) {
    if($mailcustomer->send()){      
      $response["success"] = 1;
      echo json_encode($response);
    }else{
      $response["success"] = 0;
      $response["message"] = "Oops! Customer Email not sent";
      echo json_encode($response);
    }
  }else{
    $response["success"] = 0;
        $response["message"] = "Oops! Owner Email not sent";
    echo json_encode($response);
  }
  
}else{
  
  $response["success"] = 0;
  $response["message"] = "Required field(s) is missing";
  echo json_encode($response);  
}

?>