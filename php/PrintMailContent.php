<?php  

require_once "loadIcon.php";
require_once "getConnectList.php";
$icon = load_icon($_SESSION['IdUser']);

foreach($result as $mail){
  if($mail['IdTo'] = $_SESSION['IdUser']){
    echo <<< _END
<div class="from-them" role="tabpanel" id="{$mail['MailFrom']}">
            <div class="container-fluid row">
              <form class="col-md-9">
                <div class="form-group">
                  {$mail['MailContent']}
                </div>
              </form>
            </div><!--End of inner container-->
          </div>
_END;
  }else{
    echo <<< _END
<div class="from-me" role="tabpanel" id="{$mail['MailFrom']}">
            <div class="container-fluid row">
              <form class="col-md-9">
                <div class="form-group">
                  {$mail['MailContent']}
                </div>
              </form>
            </div><!--End of inner container-->
          </div>
_END;
  }
  
}
?>
