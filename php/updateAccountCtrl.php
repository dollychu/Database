<?php

require_once "updateAccount.php";

$uid   = $_SESSION['IdUser'];
$field = $_POST['field'];
$data  = $_POST['data'];


if($field == "name"){        update_name($uid, $data);   }
else if($field == "phone"){  update_phone($uid, $data);  }
else if($field == "email"){  update_email($uid, $data);  }
else if($field == "birth"){  update_birth($uid, $data);  }
else if($field == "gender"){ update_gender($uid, $data); }


?>
