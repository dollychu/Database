<?php

require_once "login2.php";
$conn = get_connection();

require_once "GetMusicInfo.php";
$mid = getIdMusic($_SERVER['QUERY_STRING']);


$query = "SELECT Name, Content, IdComment 
          FROM Comment NATURAL JOIN User 
          WHERE IdMusic=$mid 
          ORDER BY IdComment DESC";

if(!$result = $conn->query($query)){
  echo "Failed processing the query: ".$query;
  $conn->close();
  return;
}

while($row = $result->fetch_assoc()){
  echo "
    <div class='card mb-1'>
      <div class='card-header'>".$row['Name']."</div>
      <div class='card-body'>
        <p class='card-text'>".$row['Content']."</p>
      </div>
    </div>
  ";
}

$result->free();
$conn->close();


?>
