<?php
session_start();

require_once "login.php";
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['submit'])){
  $stmt = $conn->stmt_init();
  $query = "SELECT passwd FROM User where UID=?";
  
  if(!$stmt->prepare($query)){
    print "<h1>Failed to prepare for query.</h1>";
    return 0;
  } 
  $stmt->bind_param("i", $uid);
  $uid = $_SESSION['IdUser'];
  
  $oldPwd = $_POST['oldPwd'];
  $newPwd = $_POST['newPwd'];
  $conPwd = $_POST['conPwd'];
  
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  
  if(password_verify($oldPwd, $row['passwd'])){
    $query = "UPDATE User SET passwd=? WHERE UID=$uid";
    
    if(!$stmt->prepare($query)){
      print "<h1>Failed to update password!</h1>";
      return 0;
    } 
    $stmt->bind_param("s", $hashPwd);
    $hashPwd = password_hash($newPwd, PASSWORD_DEFAULT);
    $stmt->execute();
    
    echo "<h1>Successfully update~</h1>";
    
    // Update user data
    $updateTime = date("Y-m-d H:i:s");
    $query = "UPDATE User SET UpdateAt='$updateTime' WHERE IdUser={$_SESSION['IdUser']}";
    $conn->query($query);
    
    $result->free();
    $stmt->close();
    $conn->close();
    
    header("Refresh: 1; {$_SERVER['HTTP_REFERER']}"); 
    return 1;
    
  } else{
    echo "<h1>Wrong password!</h1>";
    
    $result->free();
    $stmt->close();
    $conn->close();
    
    header("Refresh: 1; {$_SERVER['HTTP_REFERER']}"); 
    return 0;
  }
  
}



?>
