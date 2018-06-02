<?php
require_once "loadIcon.php";
require_once "login2.php";

session_start();

$uid = $_SESSION['IdUser'];
$icon = load_icon($uid);

$conn = get_connection();

$query = "SELECT Name FROM Follower NATURAL JOIN User WHERE IdFollowed=$uid";
$stmt = $conn->stmt_init();
if(!$stmt->prepare($query)){
  echo "Falied to prepare for the query!";
  $conn->close();

  return 0;
}
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows > 0){
  echo "<div class='container-fluid row'>";
  while($row = $result->fetch_assoc()){
    echo <<< _END
      <div class="card bd-dark col-md mx-1 my-1">
        <img class="card-img-top mt-2" src="../image/avator/{$icon}.png" alt="Card image cap" style="width: 130px; margin: 0 auto;">
        <div class="card-header text-center bg-secondary"></div>
        <div class="card-body text-center">
          <p class="card-text">{$row['Name']}</p>
        </div>
      </div>
_END;
  }
  echo "</div>";
}
else{
  echo "<p class='text-muted'> You don't have any follower yet. </p>";
}

$result->free();
$stmt->close();
$conn->close();


?>
