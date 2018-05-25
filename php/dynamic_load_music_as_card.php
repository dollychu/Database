<?php
require_once "login.php";

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
    
    $name = explode('.',$name)[0];
    
    if($i == 0) echo "<div class='carousel-item col-md-4 active'>";
    else echo "<div class='carousel-item col-md-4'>";
    echo <<< End
        <a style="text-decoration:none;" href="../musicPlayer.html?path={$path}">
          <div class='card text-dark' style="height: 160px; background-color: #4DF9F7;">
            <div class='card-header'>{$name}</div>
            <div class='card-body'>
              <h5 class='card-title'>Light card</h5>
              <p class='card-text'>Click to play the cong.</p>
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


