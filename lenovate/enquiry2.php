<?php

/*
 * Following code will Email admin, the query submitted by the user
 */
require 'phpmailer/PHPMailerAutoload.php';

// array for JSON response
$response = array();

// check for required fields

 if (isset($_POST['name']) && isset($_POST["email"]) && isset($_POST["prodname"]) && isset($_POST["url"]) && isset($_POST["phone"]) && isset($_POST["note"])) {
    
  $email = $_POST['email'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $note = $_POST['note'];
  $url = $_POST['url'];
  $prodname = $_POST['prodname'];

  $body1 = '<b>Item name: '.$prodname. '<b><br><br>'.
       '<img src="'.$url.'"><br><br>'.$note.'<br><br><b>Phone Number: '.$phone.'</b>';
  
  
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
      $mailowner->Subject = 'Enquiry From: '.$name;
      $mailowner->Body = $body1;
  
  
      /*------------------------ customer copy --------------------------------------*/
      $body2 = '<b>You Submitted an Enquiry About the Product Show Below: </b><br><br><img src="'.$url.'"><br><br>'.$note.'<br><br>Phone Number: <br><br><b>We will get back to you shortly!!</b>';
          
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
      $mailcustomer->Subject = 'Submission of an Enquiry to Lenovate';
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