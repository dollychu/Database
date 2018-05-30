<?php

function load_icon($uid){
  require_once "login2.php";

  $conn = get_connection();
  
  session_start();
  
  $query = "SELECT Icon FROM UserInformation WHERE IdUser=?";
  $stmt = $conn->stmt_init();
  if(!$stmt->prepare($query)){
    echo "Failed to prepare the query to load icon.";
    
    return 0;
  }
  $stmt->bind_param('s', $uid);
  $stmt->execute();
  
  $returnIcon = "no01";
  
  $result = $stmt->get_result();
  if($result->num_rows){
    $row = $result->fetch_assoc();
    $returnIcon = $row['Icon'];
  }
  
  $result->free();
  $stmt->close();
  $conn->close();
  
  return $returnIcon;
}

?>
