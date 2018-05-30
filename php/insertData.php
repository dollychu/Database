<?php
require_once "login.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['submit'])){
  $stmt = $conn->stmt_init();
  $query = "SELECT Name FROM User WHERE Name=?";
  
  if(!$stmt = $conn->prepare($query)){
    echo "<h1>Failed to prepare for query.</h1>";
    $stmt->close();
    $conn->close();
    
    return 0;
  }
  $stmt->bind_param("s", $name);
  
  $name = $_POST['name'];
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows){
      echo"<h1>Account exist!! Please use another names.</h1>";
  }
  else{
    /*** Insert User ***/
    $query = "INSERT INTO User (Name, passwd) VALUES (?,?)";
    if(!$stmt = $conn->prepare("INSERT INTO User (Name, passwd) VALUES (?,?)")){
      echo "<h1>Failed to prepare for query.</h1>";
      $result->free();
      $stmt->close();
      $conn->close();
      
      return 0;
    }
    $stmt->bind_param("ss", $name, $token);
    $passwd = $_POST['passwd'];
    $token = password_hash($passwd, PASSWORD_DEFAULT);
    if(!$stmt->execute()) echo "<h2>Insertion error when executing query</h2>";
    
    /* Fetch the id of the user we've just added */
    $tmp_result = $conn->query("SELECT IdUser FROM User WHERE Name='$name'");
    $uid = $tmp_result->fetch_assoc();
    $uid = $uid['IdUser'];
    
    
    /*Insert Email */
    if(isset($_POST['email'])){
      $query = "INSERT INTO UserEmail (IdUser, MailAddress) VALUES (?,?)";
      if(!$stmt = $conn->prepare($query)){
        echo "<h1>Failed to prepare for query.</h1>";
        $result->free();
        $stmt->close();
        $conn->close();
        
        return 0;
      }
      $stmt->bind_param("ss", $uid, $email);
      $email = $_POST['email'];
      if(!$stmt->execute()) echo "<h2>Insertion error when executing query</h2>";
    }
    
    
    /* Insert phone */
    if(isset($_POST['phone'])){
      $query = "INSERT INTO UserPhone (IdUser, PhoneNumber) VALUES (?,?)";
      if(!$stmt = $conn->prepare($query)){
        echo "<h1>Failed to prepare for query.</h1>";
        $result->free();
        $stmt->close();
        $conn->close();
        
        return 0;
      }
      $stmt->bind_param("ss", $uid, $phone);
      $phone = $_POST['phone'];
      if(!$stmt->execute()) echo "<h2>Insertion error when executing query</h2>";
    }
    
    /* Insert UserInformation */
    if(isset($_POST['gender']) && isset($_POST['birthday']) && isset($_POST['avator'])){
      $query = "INSERT INTO UserInformation (IdUser, Icon, Gender, Birthday) VALUES (?,?,?,?)";
      if(!$stmt = $conn->prepare($query)){
        echo "<h1>Failed to prepare for query.</h1>";
        $result->free();
        $stmt->close();
        $conn->close();
        
        return 0;
      }
      $stmt->bind_param("ssss", $uid, $icon, $gender, $birthday);
      $gender = $_POST['gender'];
      if($gender=="M" || $gender=="m") $gender="Boy";
      else if($gender=="F" || $gender=="f") $gender="Girl";
      else $gender="Unspecified";
      
      $icon = $_POST['avator'];
      $birthday = $_POST['birthday'];
      if(!$stmt->execute()) echo "<h2>Insertion error when executing query</h2>";
    }
    
  }
  $stmt->close();
  $result->free();
  $stmt->close();
}
$conn->close();

$wait = 1;
echo "<h4>Redirect after $wait seconds...</h4>";
header("Refresh: $wait; ../index.html");
exit();

?>
