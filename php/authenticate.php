<?php

require_once "login.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['submit'])){
  $stmt = $conn->prepare("SELECT UID, passwd FROM User WHERE Name=?");
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
    $_SESSION['UID'] = $row['UID'];
    
    
    echo "<h2>You've successfully login now.</h2>";
  }else{
    echo "<h2>Invalid password or username!</h2>";
  }

  $stmt->close();
  $result->free();
}
$conn->close();

$wait = 3;
echo"<h4>Redirect after $wait seconds</h4>";
header("Refresh: $wait; ../index.html");
exit();
?>
