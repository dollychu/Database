<?php

session_start();

if(isset($_POST['submit'])){

  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT IdMail FROM Mail;";
  
  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('MailFrom'=>$row[0]);
      $return_v[] = $assoc;
    }
  }else{
  	ALERT("Fail to process the query.");
  }

  $len = count($return_v);
  $len ++;
  $nameto = $_POST['nameTo'];
  $nameto = mysqli_real_escape_string($conn, $nameto);

  $query = "SELECT IdUser 
			FROM User
			WHERE Name ='$nameto';";

  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('id'=>$row[0]);
      $return_v[] = $assoc;
    }
  }else{
  	ALERT("Fail to process the query.");
  }

  foreach($return_v as $idnumber){
  	$idto = $idnumber['id'];
  }
    
  $stmt = $conn->stmt_init();
  $query = "INSERT INTO `Mail` (`IdMail`, `IdFrom`, `IdTo`, `Content`, `CreateAt`, `Enabled`) VALUES ($len, {$_SESSION['IdUser']}, $idto, ?, CURRENT_TIMESTAMP, '1');";
    
  if(!$stmt->prepare($query)){
    print "<h1>Failed to send mail!</h1>";
    return 0;
  } 
  $stmt->bind_param("s", $mail);
  $mail = $_POST['content'];
  $stmt->execute();
  if(!empty($stmt->error)){
  echo "Insertion error: {$stmt->error}";
  }
  else{
    echo $stmt->insert_id;
  }
    
  $result->free();
  $stmt->close();
  $conn->close();
    
  return 1;
}

?>
