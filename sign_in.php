
  
<!DOCTYPE html>
<html lang="en">
<head>
  <title> Login </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="js/document_ready.js"></script>
  
  
  
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" type="text/css" href="css/form.css">
</head>

<body>
  <div id="HEADER"></div>
  <div class="container">
    <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png">
      <p id="profile-name" class="profile-name-card"></p>
      
      <form class="form-signin" action="sign_in.php" method="POST">
        <span id="reauth-email" class="reauth-email"></span>
        <input type="text" id="inputEmail" class="form-control" placeholder="User name" required autofocus name="name">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="passwd">
        <input class="btn btn-primary btn-block btn-signin" type="submit" name="submit" value="Login" id="submit">
      </form><!-- /form -->
      <p id="tmp"></p>
      <a href="#" class="forgot-password">
          Forgot the password?
      </a>
      <a href="create_acount.html" class="forgot-password">
          Create acount
      </a>
    </div><!-- /card-container -->
  </div><!-- /container -->
  </body>
</html>
<!--script src="sign_in.js"></script-->

<?php

if(isset($_POST['submit'])){
  require_once "php/login.php";
  $conn = new mysqli($hn, $un, $pw, $db);
  if($conn->connect_error) die($conn->connect_error);

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
    
    $msg = "Success~";
  }
  else{
    $msg = "Invalid password or username!";
    $redirect = "sign_in.php";
  }

  $stmt->close();
  $result->free();
  $conn->close();

  $wait = 0;
  echo"<script> alert('$msg'); </script>";
  header("Refresh: $wait; $redirect");
}

?>


