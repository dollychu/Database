<?php

$result = getConnect($_SESSION['IdUser']);

if(empty($result)){
  echo "<p> you don't have any mail. </p>";
  return;
}

foreach($result as $mail){
  echo <<< _END
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#{$mail['MailTo']}" role="tab"> {$mail['MailTo']} </a>
_END;
}

function getConnect($uid){
  require_once "login2.php";
  $conn = get_connection();
  
  $query = "SELECT User.Name as contact, Mail.Content, Mail.IdFrom, Mail.CreateAt, Mail.IdTo, Mail.Enabled
            FROM User INNER JOIN Mail 
            WHERE Mail.IdFrom={$_SESSION['IdUser']} AND User.Name in(SELECT Name FROM User WHERE IdUser=Mail.IdTo) OR Mail.IdTo={$_SESSION['IdUser']} AND User.Name in(SELECT Name FROM User WHERE IdUser=Mail.IdFrom)";
  
  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('MailFrom'=>$uid, 'IdTo'=>$row[4], 'MailContent'=>$row[1], 'SentDate'=>explode(' ',$row[2])[0], 'Shows'=>$row[3]);
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
