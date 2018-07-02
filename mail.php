
<!--<?php $_SESSION['MSG'] = "Please login first."; ?>
<?php include "php/checkLogin.php"; ?>-->


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

        section {
          max-width: 450px;
          margin: 50px auto;
          div {
            max-width: 255px;
            word-wrap: break-word;
            margin-bottom: 20px;
            line-height: 24px;
          }
        }

        .clear {
          clear: both
        }

        .from-me {
          position: relative;
          padding: 10px 20px;
          color: white;
          background: #0B93F6;
          border-radius: 25px;
          float: right;
          &:before {
            content: "";
            position: absolute;
            z-index: -1;
            bottom: -2px;from-me loud
            right: -7px;
            height: 20px;
            border-right: 20px solid #0B93F6;
            border-bottom-left-radius: 16px 14px;
            -webkit-transform: translate(0, -2px);
          }
          &:after {
            content: "";
            position: absolute;
            z-index: 1;
            bottom: -2px;
            right: -56px;
            width: 26px;
            height: 20px;
            background: white;
            border-bottom-left-radius: 10px;
            -webkit-transform: translate(-30px, -2px);
          }
        }

        .from-them {
          position: relative;
          padding: 10px 20px;
          background: #E5E5EA;
          border-radius: 25px;
          color: black;
          float: left;
          &:before {
            content: "";
            position: absolute;
            z-index: 2;
            bottom: -2px;
            left: -7px;
            height: 20px;
            border-left: 20px solid #E5E5EA;
            border-bottom-right-radius: 16px 14px;
            -webkit-transform: translate(0, -2px);
          }
          &:after {
            content: "";
            position: absolute;
            z-index: 3;
            bottom: -2px;
            left: 4px;
            width: 26px;
            height: 20px;
            background: white;
            border-bottom-right-radius: 10px;
            -webkit-transform: translate(-30px, -2px);
          }
        }
    </style>
  </head>

  <body>
    <div id="HEADER"></div>
    <div class='container-fluid'>
      <div class="row mx-auto">
        <div class="list-group col-sm-3 mb-3" id="settingList" role="tablist">
          <!-- Contact List pane -->
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
