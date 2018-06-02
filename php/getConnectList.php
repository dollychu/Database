<?php

$result = getConnect($_SESSION['IdUser']);

foreach($result as $mail){
  echo <<< _END
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#{$mail['MailTo']}" role="tab"> {$mail['MailTo']} </a>
_END;
}



function getConnect($uid){
  require_once "login2.php";
  $conn = get_connection();
  
  $query = "SELECT User.Name, Mail.Content, Mail.CreateAt, Mail.Enabled FROM User INNER JOIN Mail WHERE IdUser=(SELECT IdTo FROM User INNER JOIN Mail WHERE IdFrom=IdUser AND Name=$uid)";
  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('MailFrom'=>$uid, 'MailTo'=>$row[0], 'MailContent'=>$row[1], 'SentDate'=>explode(' ',$row[2])[0], 'Shows'=>$row[3]);
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
