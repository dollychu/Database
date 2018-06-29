<?php  
session_start();

include "loadIcon.php";
$icon = load_icon($_SESSION['IdUser']);

echo <<< _END
  <div class="container-fluid row">
    <form class="col-md-9" id="AccInfo" style="background-color: rgba(255,255,255,0.75); border-bottom: solid 2px gray;">
      <div class="form-group row">
        <label for="accountName" class="col-sm-3 col-form-label">Your Name:</label>
        <div class="col-sm-9">
          <input type="text" class="form-control-plaintext" value="{$_SESSION['UserName']}" id="name">
        </div>
      </div>

      <div class="form-group">
        <div class="form-group row">
          <label for="birthdayInfo" class="col-sm-3 col-form-label">Birthday:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="{$_SESSION['UserBirthday']}" id="birth">
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-group row">
          <label for="phoneInfo" class="col-sm-3 col-form-label">Phone:</label>
          <div class="col-sm-9">
            <input type="tel" class="form-control-plaintext" value="{$_SESSION['UserPhone']}" id="phone" minlength="10" maxlength="10">
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-group row">
          <label for="emailInfo" class="col-sm-3 col-form-label">Email Address:</label>
          <div class="col-sm-9">
            <input type="email" class="form-control-plaintext" value="{$_SESSION['UserEmail']}" id="email">
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-group row">
          <label for="genderInfo" class="col-sm-3 col-form-label">Gender:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control-plaintext" value="{$_SESSION['UserGender']}" id="gender" placeholder="M/F/U">
          </div>
        </div>
      </div>

    </form>
    <div class="col-md-3 mb-2">
      <img src='image/avator/$icon.png' width='250px'>
    </div>
  </div><!--End of inner container-->
_END;
?>
