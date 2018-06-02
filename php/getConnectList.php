<?php

$result = getConnectList($_SESSION['IdUser']);

foreach($result as $contact){
  echo <<< _END
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#{$contact['ContactUser']}" role="tab"> {$mail['ContactUser']} </a>
_END;
}

function getConnectList($uid){
  require_once "login2.php";
  $conn = get_connection();
  $query = "SELECT DISTINCT User.Name FROM User INNER JOIN Mail WHERE IdUser IN (SELECT DISTINCT IdTo FROM User INNER JOIN Mail WHERE IdFrom=IdUser AND Name=$uid) OR IdUser IN (SELECT DISTINCT IdFrom FROM User INNER JOIN Mail WHERE IdTo=IdUser AND Name=$uid)";

  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('ContactUser'=>$row[0]);
      $return_v[] = $assoc;
    }
    return $return_v;
  }
  
  ALERT("Fail to process the query.");
  return 0;
}

function ALERT($msg){
  echo "<script> alert('$msg'); </script>";
}

?>
