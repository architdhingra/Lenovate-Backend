<?php
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $image = $_POST['image'];
                $name = $_POST['name'];
 
 require_once('db_connect2.php');
         $db = new DB_CONNECT(); $db = $db->connect();
 $sql ="SELECT id FROM chatimages ORDER BY id ASC";
 
 $res = mysqli_query($db, $sql);
 
 $id = 0;
 
 while($row = mysqli_fetch_array($res)){
 $id = $row['id'];
 }
 
 $path = "uploads/$id.png";
 
 $actualpath = "http://www.meracut.com/wnd/$path";
 
 $sql = "INSERT INTO chatimages (photo,name) VALUES ('$actualpath','$name')";
 
 if(mysqli_query($db, $sql)){
 file_put_contents($path,base64_decode($image));
 echo "Successfully Uploaded";
 }
 
 mysqli_close();
 }else{
 echo "Error";
 }
 ?>