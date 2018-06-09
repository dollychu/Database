
<?php

require_once "login2.php";
$conn = get_connection();

$stmt = $conn->prepare("SELECT IdUser, Name, passwd FROM User WHERE Name=?");
$stmt->bind_param("s", $name);
$name = $_POST['name'];
$stmt->execute();
$result = $stmt->get_result();
if(!$result) die($conn->error);

$row = $result->fetch_assoc();
$db_token = $row['passwd'];
$passwd = $_POST['passwd'];

$msg = "";
$redirect = "index.html";
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
  echo json_encode(array("success"=>1));
}
else{
  echo json_encode(array("success"=>0));
  $redirect = "sign_in.php";
}

$stmt->close();
$result->free();
$conn->close();

?>
