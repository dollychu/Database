<?php

require_once "login2.php";
$conn = get_connection();

session_start();

$stmt = $conn->stmt_init();

$query = "SELECT IdMusic FROM Music WHERE MusicStoredPath=?";
if(!$stmt->prepare($query)){
  echo "Failed to prepare query: ".$query;
  return;
}
$stmt->bind_param('s', $music_path);
$music_path = $_POST['music_path'];

$stmt->execute();
$result = $stmt->get_result();
$mid = $result->fetch_assoc()['IdMusic'];

$result->free();

// Insert comment
$query = "INSERT INTO Comment(IdUser, IdMusic, Content) VALUES({$_SESSION['IdUser']}, $mid, ?)";
if(!$stmt->prepare($query)){
  echo "Failed to prepare query: ".$query;
  return;
}
$stmt->bind_param('s', $content);
$content = $_POST['comment'];

$stmt->execute();
if(!empty($stmt->error)){
  echo "Insertion error: {$stmt->error}";
}
else{
  echo $stmt->insert_id;
}

$stmt->close();
$conn->close();

return;
?>
