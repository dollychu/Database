<?php
require_once "login.php";
include "GetMusicInfo.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

$MAX_CARD_NUM = 7;

$query = "SELECT Name, MusicStoredPath FROM Music ORDER BY rand() LIMIT {$MAX_CARD_NUM}";
$stmt = $conn->stmt_init();
if(!$stmt->prepare($query)){
  print "Failed to prepare for query.";
} 
else{
  $stmt->execute();
  $result = $stmt->get_result();
 
  
  $i = 0;
  while($h = $result->fetch_array(MYSQLI_NUM)){
    $name = $h[0];
    $path = $h[1];
    $viewed   = getViewedNum($path);
    $uploader = getUploader($path);
    $date     = getUploadDate($path);
    
    $name = pathinfo($name, PATHINFO_FILENAME);
    
    if($i == 0) echo "<div class='carousel-item col-md-4 active'>";
    else echo "<div class='carousel-item col-md-4'>";
    echo <<< End
        <a style="text-decoration:none;" href="../musicPlayer.php?path=$path">
          <div class='card text-dark' style="height: 160px; background-image: linear-gradient(#ffffff, #aad7ff);">
            <div class='card-body'>
              <h5 class='card-title'>$name</h5>
              <div class='container text-info'>
                <small class='card-text row'> Viewed: $viewed </small>
                <small class='card-text row'> Uploaded by $uploader </small>
                <small class='card-text row'> Uploaded at $date </small>
              </div>
            </div>    
          </div>
        </a>
      </div>
End;
    ++$i;
  }
  $stmt->close();
}
$conn->close();
    
?>


