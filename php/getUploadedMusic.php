<?php

$result = getUpload($_SESSION['IdUser']);

if(!count($result)){
  echo "<p class='text-muted'> You haven't uploaded anything yet. </p>";
  return 1;
}

foreach($result as $song){
echo <<< _END
  <div class="card text-dark mb-2" id="{$song['IdMusic']}{$_SESSION['IdUser']}">
    <img class="card-img-top mx-auto mt-3" src="image/double_note.png" style="width: 200px;">
    <a style="text-decoration:none;" href="musicPlayer.php?path={$song['Path']}">
      <div class="card-body text-dark">
        <h4 class="card-title text-center"> {$song['MusicName']} </h4>
        
        <div class="row mb-2">
          <div class="col-3 text-right"><p class="card-text"> Uploader </p></div>
          <div class="col-9"><p class="card-text"> {$song['UserName']} </p></div>
        </div>
        <div class="row mb-2">
          <div class="col-3 text-right"><p class="card-text"> Date </p></div>
          <div class="col-9"><p class="card-text"> {$song['UploadDate']} </p></div>
        </div>
        <div class="row mb-2"> 
          <div class="col-3 text-right"><p class="card-text"> Description </p></div>
          <div class="col-9"><p class="card-text mt-2"> {$song['Description']} </p></div>
        </div>

      </div><!-- End of card-body -->
    </a>
_END;
$button = "<button type='button' class='btn btn-outline-danger mb-2 mx-auto' id='{$song['IdMusic']}_{$_SESSION['IdUser']}'>Remove</button>";  
echo $song['UploadUser'] == $_SESSION['IdUser'] ? "$button" : '';
echo "</div>";
}

function getUpload($uid){
require_once "login2.php";
$conn = get_connection();

$query = "SELECT User.Name, Music.Name, Music.MusicStoredPath, Music.Description, Music.createAt, Music.IdMusic, Music.UploadUser FROM Music INNER JOIN User WHERE User.IdUser=Music.UploadUser AND Music.UploadUser=$uid";
if($result = $conn->query($query)){
    $return_v = array();
    while($row = $result->fetch_array()){
      $assoc = array('UserName'=>$row[0], 'MusicName'=>explode('.', $row[1])[0], 'Path'=>$row[2], 'Description'=>$row[3], 'UploadDate'=>explode(' ',$row[4])[0], 'IdMusic'=>$row[5], 'UploadUser'=>$row[6]);
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
