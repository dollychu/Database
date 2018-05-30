<?php

require_once "login.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['submit'])){
  $stmt = $conn->prepare("SELECT IdUser, Name, passwd FROM User WHERE Name=?");
  $stmt->bind_param("s", $name);
  $name = $_POST['name'];
  $stmt->execute();
  $result = $stmt->get_result();
  if(!$result) die($conn->error);

  $row = $result->fetch_assoc();
  $db_token = $row['passwd'];
  $passwd = $_POST['passwd'];
  
  if(password_verify($passwd, $db_token)){
    session_start();
    $_SESSION['IdUser'] = $row['IdUser'];
    $_SESSION['UserName'] = $row['Name'];
    $_SESSION['UserPhone'] = "";
    $_SESSION['UserEmail'] = "";
    $_SESSION['UserGender'] = "";
    $_SESSION['UserBirthday'] = "";

    $query = "SELECT PhoneNumber FROM UserPhone WHERE IdUser=\"{$row['IdUser']}\""; 
    if(($result = $conn->query($query)) && $result->num_rows){
      $r = $result->fetch_assoc();
      $_SESSION['UserPhone'] = $r['PhoneNumber'];
    }

    $query = "SELECT MailAddress FROM UserEmail WHERE IdUser=\"{$row['IdUser']}\""; 
    if(($result = $conn->query($query)) && $result->num_rows){
      $r = $result->fetch_assoc();
      $_SESSION['UserEmail'] = $r['MailAddress'];
    }

    $query = "SELECT Gender, Birthday FROM UserInformation WHERE IdUser=\"{$row['IdUser']}\"";
    if(($result = $conn->query($query)) && $result->num_rows){
      $r = $result->fetch_assoc();
      $_SESSION['UserGender'] = $r['Gender'];
      $_SESSION['UserBirthday'] = $r['Birthday'];
    }
    
    $json_stat = array("status"=>1, "msg"=>"Success");
    echo json_encode($json_stat);
  }
  else{
    $json_stat = array("status"=>0, "msg"=>"Invalid password or user name!");
    echo json_encode($json_stat);
  }

  $stmt->close();
  $result->free();
}
$conn->close();
?>
