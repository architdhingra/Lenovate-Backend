<?php
 
 require 'phpmailer/PHPMailerAutoload.php';
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
  if(isset($_POST["image"])){
    
    $image = $_POST['image'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $note = $_POST['note'];

    date_default_timezone_set("Asia/Kolkata");    // set time zone accordingly
    $date= date('Y-m-d-H-s');
    $path = "user_enquiries/"."img_".$date.".png";
    $actualpath = 'http://www.woodndecor.in/'.$path;
    
    if(file_put_contents($path,base64_decode($image))!=false){
      
      
      
      /*------------------------ customer copy --------------------------------------*/
      $body1 = $name.' wants to Enquire About the Product Show Below: <br><br><img src="'.$actualpath.'"><br><br>'.$note.'<br><br>Phone Number: '.$phone;
      
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
      $mailowner->Subject = 'Enquiry By Image From: '.$name;
      $mailowner->Body = $body1;
      
      
      /*------------------------ customer copy --------------------------------------*/
      $body2 = '<b>You Submitted an Enquiry About the Product Show Below: </b><br><br><img src="'.$actualpath.'"><br><br>'.$note.'<br><br><br><b>We will get back to you shortly!!</b>';
          
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
            echo "success : ".$actualpath;
          }else{
            echo "error sending customer mail";
          }
        }else{
          echo "error sending owner mail";
        }
    }
      
  
  }else{
    echo "Error: Required field is missing";
  }
 }else{
   echo "request error";
 }