<?php 

session_start();
if(isset($_SESSION['UID'])){
  $msg = "<script 'type=text/javascript'> alert('You\'ve already logged in now~'); window.location.href= \"{$_SERVER['HTTP_REFERER']}\"; </script>";
  echo $msg;
  exit;
}

?>
  
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
      <form class="form-signin" action="php/authenticate.php" method="POST">
        <span id="reauth-email" class="reauth-email"></span>
        <input type="text" id="inputEmail" class="form-control" placeholder="User name" required autofocus name="name">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="passwd">
        <input class="btn btn-primary btn-block btn-signin" type="submit" name="submit" value="Login">
      </form><!-- /form -->
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
