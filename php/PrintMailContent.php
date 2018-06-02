<?php  
session_start();

include "loadIcon.php";
include "getConnectList.php";
$icon = load_icon($_SESSION['IdUser']);

foreach($result as $contact){
  echo <<< _END
          <div class="tab-pane fade show active" role="tabpanel" id="{$contact['ContactUser']}">
_END;

  $mails = getMailContent($contact['ContactUser']);
  foreach($mails as $content){
    echo <<< _END
            <div class="container-fluid row">
              <form class="col-md-9">
                <div class="form-group row">
                  <label for="accountName" class="col-sm-3 col-form-label">From:</label>
                  <div class="col-sm-9">
                    <input type="text" readonly class="form-control-plaintext" value="{$content['MailFrom']}">
                  </div>
                </div>

                <div class="form-group">
                  <div class="form-group row">
                    <label for="birthdayInfo" class="col-sm-3 col-form-label">To:</label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" value="{$content['MailTo']}">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  {$mail['MailContent']}
                </div>

                <div class="form-group">
                  <div class="form-group row">
                    <label for="birthdayInfo" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <input type="text" readonly class="form-control-plaintext" value="{$mail['SentTime']}">
                    </div>
                  </div>
                </div>

              </form>
            </div><!--End of inner container-->         
_END;
  }
  echo "</div>";
}

function getMailContent($otherUsr){
  require_once "login2.php";
  $conn = get_connection();
  $query = "SELECT DISTINCT (SELECT Name FROM User WHERE IdUser=Mail.IdFrom) AS usrFrom, (SELECT Name FROM User WHERE IdUser=Mail.IdTo) AS usrTo, Mail.Content, Mail.CreateAt, Mail.Enabled FROM User INNER JOIN Mail WHERE (IdFrom=(SELECT IdUser FROM User WHERE NAME=$otherUsr) AND IdTo=(SELECT IdUser FROM User WHERE NAME=$_SESSION['IdUser'])) OR (IdFrom=(SELECT IdUser FROM User WHERE NAME=$_SESSION['IdUser']) AND IdTo=(SELECT IdUser FROM User WHERE NAME=$otherUsr))";

  if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('MailFrom'=>$row[0],'MailTo'=>$row[1],'MailContent'=>$row[2],'SentTime'=>$row[3], 'display'=>$row[4]);
      $return_v[] = $assoc;
    }
    return $return_v;
  }
  
  ALERT("Fail to process the query.");
  return 0;
}

function ALERT($msg){
  echo "<script> alert('$msg'); </script>";
}

?>
