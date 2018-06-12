<?php
require_once "login.php";

$success = 0;
$return_msg = "";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

$stmt = $conn->stmt_init();
$query = "SELECT Name FROM User WHERE Name=?";

if(!$stmt = $conn->prepare($query)){
  $return_msg = "Failed to prepare for query: $query";
  $stmt->close();
  $conn->close();
  
  echo json_encode(array("success"=>$success, "msg"=>$return_msg));
  return;
}
$stmt->bind_param("s", $name);

$name = $_POST['name'];
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows){
  $return_msg = "Account exist!! Please use another names.";
}
else{
  /*** Insert User ***/
  $query = "INSERT INTO User (Name, passwd) VALUES (?,?)";
  if(!$stmt = $conn->prepare("INSERT INTO User (Name, passwd) VALUES (?,?)")){
    $return_msg = "Failed to prepare for query: ".$query;
    $stmt->close();
    $conn->close();
    
    echo json_encode(array("success"=>$success, "msg"=>$return_msg));
    return;
  }
  $stmt->bind_param("ss", $name, $token);
  $passwd = $_POST['passwd'];
  $token = password_hash($passwd, PASSWORD_DEFAULT);
  if(!$stmt->execute()) $return_msg = "Insertion error when executing query: $query\n";
  $uid = $stmt->insert_id;
  
  
  /*Insert Email */
  if(isset($_POST['email'])){
    $query = "INSERT INTO UserEmail (IdUser, MailAddress) VALUES (?,?)";
    if(!$stmt = $conn->prepare($query)){
      $return_msg = $return_msg."Failed to prepare for query: ".$query;
      $result->free();
      $stmt->close();
      $conn->close();
      
      echo json_encode(array("success"=>$success, "msg"=>$return_msg));
      return;
    }
    $stmt->bind_param("ss", $uid, $email);
    $email = $_POST['email'];
    if(!$stmt->execute()) $return_msg = $return_msg."Insertion error when executing query: $query\n";
  }
  
  
  /* Insert phone */
  if(isset($_POST['phone'])){
    $query = "INSERT INTO UserPhone (IdUser, PhoneNumber) VALUES (?,?)";
    if(!$stmt = $conn->prepare($query)){
      $return_msg = $return_msg."Failed to prepare for query: ".$query;
      $result->free();
      $stmt->close();
      $conn->close();
      
      echo json_encode(array("success"=>$success, "msg"=>$return_msg));
      return;
    }
    $stmt->bind_param("ss", $uid, $phone);
    $phone = $_POST['phone'];
    if(!$stmt->execute()) $return_msg = $return_msg."Insertion error when executing query: $query\n";
  }
  
  /* Insert UserInformation */
  if(isset($_POST['gender']) && isset($_POST['birthday']) && isset($_POST['avator'])){
    $query = "INSERT INTO UserInformation (IdUser, Icon, Gender, Birthday) VALUES (?,?,?,?)";
    if(!$stmt = $conn->prepare($query)){
      $return_msg = $return_msg."Failed to prepare for query: ".$query;
      $result->free();
      $stmt->close();
      $conn->close();
      
      echo json_encode(array("success"=>$success, "msg"=>$return_msg));
      return;
    }
    $stmt->bind_param("ssss", $uid, $icon, $gender, $birthday);
    $gender = $_POST['gender'];
    if($gender=="M" || $gender=="m") $gender="Boy";
    else if($gender=="F" || $gender=="f") $gender="Girl";
    else $gender="Unspecified";
    
    $icon = $_POST['avator'];
    $birthday = $_POST['birthday'];
    if(!$stmt->execute()) $return_msg = $return_msg."Insertion error when executing query: $query\n";
  }
  
  $success = 1;
  $return_msg = $return_msg."Welcome join us~~";
}
$stmt->close();
$result->free();
$stmt->close();

$conn->close();

echo json_encode(array("success"=>$success, "msg"=>$return_msg));


?>
