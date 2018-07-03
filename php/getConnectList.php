<?php

$result = getConnect($_SESSION['IdUser']);

if(empty($result)){
  echo "<p> you don't have any mail. </p>";
  return;
}
$i = 0;
foreach($result as $mail){
  if($i == 0){
    echo <<< _END
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#{$mail['MailFrom']}" role="tab"> {$mail['MailFrom']} </a>
_END;
  }else{
    echo <<< _END
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#{$mail['MailFrom']}" role="tab"> {$mail['MailFrom']} </a>
_END;
  }
  $i ++;
}

function getConnect($uid){
  require_once "login2.php";
  $conn = get_connection();
  
  $query = "SELECT User.Name as contact
    FROM User INNER JOIN Mail 
    WHERE Mail.IdFrom={$_SESSION['IdUser']} AND User.Name in(SELECT Name FROM User WHERE IdUser=Mail.IdTo) or Mail.IdTo={$_SESSION['IdUser']} AND User.Name in(SELECT Name FROM User WHERE IdUser=Mail.IdFrom)
    GROUP BY User.Name;";
  
  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('MailFrom'=>$row[0]);
      $return_v[] = $assoc;
    }
    
    return $return_v;
  }
  
  ALERT("Fail to process the query.");
  return 0;
}

/*
function getConnect($uid){
  require_once "login2.php";
  $conn = get_connection();
  
  $query = "SELECT User.Name as contact, Mail.Content, Mail.IdFrom, Mail.CreateAt, Mail.IdTo, Mail.Enabled
            FROM User INNER JOIN Mail 
            WHERE Mail.IdFrom=43 AND User.Name in(SELECT Name FROM User WHERE IdUser=Mail.IdTo) OR Mail.IdTo=43 AND User.Name in(SELECT Name FROM User WHERE IdUser=Mail.IdFrom)";{$_SESSION['IdUser']}
  
  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('MailFrom'=>$row[0], 'IdTo'=>$row[4], 'MailContent'=>$row[1], 'SentDate'=>explode(' ',$row[2])[0], 'Shows'=>$row[3]);
      $return_v[] = $assoc;
    }
    
    return $return_v;
  }
  
  ALERT("Fail to process the query.");
  return 0;
}
*/

function ALERT($msg){
  echo "<script> alert('$msg'); </script>";
}

?>
