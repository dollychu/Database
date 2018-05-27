
<?php include "php/checkLogin.php"; ?>
<?php $_SESSION['MSG'] = "Please login first."; ?>

<!DOCTYPE html>
<html lang="en">
  <<head>
    <<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> MUlody Project </title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src='js/document_ready.js'></script>
    <script src='js/check_match.js'></script>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='css/carousel_style.css'>
    <style>
        body{ padding-top: 70px; }
    </style>
  </head>

  <body>
    <div id="HEADER"></div>
    <div class='container-fluid'>
      <div class="row mx-auto">
        <div class="list-group col-sm-3 mb-3" id="settingList" role="tablist">
          <a class="list-group-item list-group-item-action active" data-toggle="list" href="#accountInfo" role="tab">Account Info</a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#upload" role="tab">Your Upload</a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#followers" role="tab">Followers</a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#security" role="tab">Security</a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#others" role="tab">Others</a>
        </div>
        <div class="tab-content col-sm-9">
          <div class="tab-pane fade show active" role="tabpanel" id="accountInfo"></div>
          <div class="tab-pane fade" role="tabpanel" id="upload"></div>
          <div class="tab-pane fade" role="tabpanel" id="followers"></div>
          
          <div class="tab-pane fade" role="tabpanel" id="security">
            <div class="container-fulid row">
              <form class="col-md-7 mr-auto" action="php/changePassword.php" method="POST">
                <div class="form-group"><input type="password" class="form-control" name="oldPwd" placeholder="Old password" required></div>
                <div class="form-group"><input type="password" class="form-control" name="newPwd" placeholder="Enter new password" required id="newPwd" onkeyup="checkMatch();"></div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" class="form-control" name="conPwd" placeholder="Confirm again" required id="conPwd" onkeyup="checkMatch();">
                    <div class="input-group-append"><span class="input-group-text" id="confirm_status"></span></div>
                  </div>
                </div>
                <div class="form-group"><input type="submit" class="btn btn-primary disabled" value="submit" name="submit" id="submit"></div>
              </div>
            </form>
          </div>
          
          <div class="tab-pane fade" role="tabpanel" id="others"></div>
        </div>
      </div><!--End of row-->
    </div><!--End of container-->
  </body>
</html>
