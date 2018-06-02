<?php  
session_start();

include "loadIcon.php";
include "getConnectList.php"
$icon = load_icon($_SESSION['IdUser']);

foreach($result as $mail){
  echo <<< _END
          <div class="tab-pane fade show active" role="tabpanel" id="{$mail['MailTo']}">
            <div class="container-fluid row">
              <form class="col-md-9">
                <div class="form-group row">
                  <label for="accountName" class="col-sm-3 col-form-label">From:</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="{$_SESSION['UserName']}">
                  </div>
                </div>

                <div class="form-group">
                  <div class="form-group row">
                    <label for="birthdayInfo" class="col-sm-3 col-form-label">To:</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" value="{$mail['MailTo']}">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  {$mail['MailContent']}
                </div>
              </form>
            </div><!--End of inner container-->
          </div>
_END;

?>
