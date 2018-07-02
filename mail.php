
<?php $_SESSION['MSG'] = "Please login first."; ?>
<?php include "php/checkLogin.php"; ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> MUlody Project </title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src='js/document_ready.js'></script>
    <script src='js/check_match.js'></script>
    
    <link href="css/chat_bubble.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ padding-top: 70px; }
        .card-img-left {
          border-bottom-left-radius: calc(.25rem - 1px);
          border-top-left-radius: calc(.25rem - 1px);
          float: left;
          padding-right: 1em;
          margin-bottom: -1.25em;
          object-fit: cover;
        }
    </style>
  </head>

  <body>
    <div id="HEADER"></div>
    <div class='container-fluid'>
      <div class="row mx-auto">
        <div class="list-group col-sm-3 mb-3" id="settingList" role="tablist">
      <?php include "php/getConnectList.php";  ?>
        </div>
        <div class="tab-content col-sm-9">
          <!-- Mail Content pane -->
          <?php include "php/PrintMailContent.php";  ?>
        </div>
      </div><!--End of row-->
    </div><!--End of container-->
  </body>
</html>
