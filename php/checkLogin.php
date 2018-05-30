<?php

session_start();
if(!isset($_SESSION['IdUser'])){
  if(isset($_SESSION['MSG'])){
    echo "<script>
            alert(\"{$_SESSION['MSG']}\"); 
            window.location.href= '../sign_in.php'; 
          </script>";
  } else{
    header("Location: sign_in.php");
  }
}
?>



