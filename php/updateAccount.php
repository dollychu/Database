<?php
/*
This file including following functions:
  update_gender($uid, $data)
  update_birth($uid, $data)
  update_email($uid, $data)
  update_phone($uid, $data)
  update_name($uid, $data)
  update_updateDate($uid)

Each of above is used for updating one of the user's information.
The $data variable indicate the new data to be updated.
The return value(except update_udpateDate) to front-end web is a json object including attribute:
  "success{0, 1}", "msg{'Message here'}". 

*/


require_once "login2.php";
session_start();


function update_gender($uid, $data){
  $conn = get_connection();
  $stmt = $conn->stmt_init();

  $query = "UPDATE UserInformation SET Gender=? WHERE IdUser=$uid";
  if(!$stmt->prepare($query)){
    echo json_encode(array("success" => 0, "msg" => "Invalid query: $query"));
    $stmt->close();
    $conn->close();
    return;
  }

  $stmt->bind_param('s', $gender);
  
  $gender = $data;
  if($gender=="M" || $gender=="m") $gender="Boy";
  else if($gender=="F" || $gender=="f") $gender="Girl";
  else $gender="Unspecified";

  if(!$stmt->execute()){
    echo json_encode(array("success" => 0, "msg" => $stmt->error));
    $stmt->close();
    $conn->close();
    return;
  }

  echo json_encode(array("success" => 1, "msg" => $gender));
  $_SESSION['UserGender'] = $gender;
  update_updateDate($uid);
  $stmt->close();
  $conn->close();

  return;
}

function update_birth($uid, $data){
  $conn = get_connection();
  $stmt = $conn->stmt_init();

  $query = "UPDATE UserInformation SET Birthday=? WHERE IdUser=$uid";
  if(!$stmt->prepare($query)){
    echo json_encode(array("success" => 0, "msg" => "Invalid query: $query"));
    $stmt->close();
    $conn->close();
    return;
  }

  $stmt->bind_param('s', $data);
  if(!$stmt->execute()){
    echo json_encode(array("success" => 0, "msg" => $stmt->error));
    $stmt->close();
    $conn->close();
    return;
  }

  echo json_encode(array("success" => 1));
  $_SESSION['UserBirthday'] = $data;
  update_updateDate($uid);
  $stmt->close();
  $conn->close();

  return;
}

function update_email($uid, $data){
  $conn = get_connection();
  $stmt = $conn->stmt_init();

  // Check if the new email address has been used. If yes, then forbid the change.
  $query = "SELECT MailAddress FROM UserEmail WHERE MailAddress=?";
  $stmt->prepare($query);
  $stmt->bind_param('s', $data);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows != 0){
    echo json_encode(array('success' => 0, 'msg' => "Email exist! Please choose another one."));
    $stmt->close();
    $conn->close();
    return;
  }

  $query = "UPDATE UserEmail SET MailAddress=? WHERE IdUser=$uid";
  if(!$stmt->prepare($query)){
    echo json_encode(array("success" => 0, "msg" => "Invalid query: $query"));
    $stmt->close();
    $conn->close();
    return;
  }

  $stmt->bind_param('s', $data);
  if(!$stmt->execute()){
    echo json_encode(array("success" => 0, "msg" => $stmt->error));
    $stmt->close();
    $conn->close();
    return;
  }

  echo json_encode(array("success" => 1));
  $_SESSION['UserEmail'] = $data;
  update_updateDate($uid);
  $stmt->close();
  $conn->close();

  return;
}

function update_phone($uid, $data){
  $conn = get_connection();
  $stmt = $conn->stmt_init();

  $query = "UPDATE UserPhone SET PhoneNumber=? WHERE IdUser=$uid";
  if(!$stmt->prepare($query)){
    echo json_encode(array("success" => 0, "msg" => "Invalid query: $query"));
    $stmt->close();
    $conn->close();
    return;
  }

  $stmt->bind_param('s', $data);
  if(!$stmt->execute()){
    echo json_encode(array("success" => 0, "msg" => $stmt->error));
    $stmt->close();
    $conn->close();
    return;
  }

  echo json_encode(array("success" => 1));
  update_updateDate($uid);
  $_SESSION['UserPhone'] = $data;
  $stmt->close();
  $conn->close();

  return;
}

function update_name($uid, $data){
  $conn = get_connection();
  $stmt = $conn->stmt_init();

  // Check if the new name has been used. If yes, then forbid to change the name.
  $query = "SELECT Name FROM User WHERE Name=?";
  $stmt->prepare($query);
  $stmt->bind_param('s', $data);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows != 0){
    echo json_encode(array('success' => 0, 'msg' => "Name exist! Please choose another one."));
    $stmt->close();
    $conn->close();
    return;
  }
  
  // Check ok and update the name.
  $query = "UPDATE User SET Name=? WHERE IdUser=$uid";
  if(!$stmt->prepare($query)){
    echo json_encode(array('success' => 0, 'msg' => "Fail to prepare query: $query"));
    $stmt->close();
    $conn->close();
    return;
  }

  $stmt->bind_param('s', $data);
  if(!$stmt->execute()){
    echo json_encode(array('success' => 0, 'msg' => $stmt->error));
    $stmt->close();
    $conn->close();
    return;
  }

  echo json_encode(array('success' => 1));
  update_updateDate($uid);
  $_SESSION['UserName'] = $data;
  $stmt->close();
  $conn->close();

  return;
}

function update_updateDate($uid){
  $conn = get_connection();

  $updateTime = date("Y-m-d H:i:s");
  $query = "UPDATE User SET UpdateAt='$updateTime' WHERE IdUser=$uid";
  if(!$conn->query($query)){
    echo "Failed to update update_date: ".$conn->error;
  }

  $conn->close();
}

?>
