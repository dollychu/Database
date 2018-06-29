<?php

require_once "utils.php";

$url    = $_SERVER['QUERY_STRING'];
$listId = decodeUrlVar($url, "list_id");

if(!$listId || !isset($_SESSION['playlist'])){
  unset($_SESSION['playlist']);
  $_SESSION['playlist'] = randomSelect(10, urldecode($url));
}
else{
  $path  = $_SESSION['playlist'];
  $i = 0;
  foreach($path as $m){
    $name = explode('.', $m)[0];
    if(strpos($name, '/') !== false){
      $name = explode('/', $name);
      $name = end($name);
    }
    $active = $i==$listId ? "active" : "";
    
    echo "
      <a class='list-group-item list-group-item-action $active' m_path='$m' href='#'> 
        $name
      </a> \n
    ";
    
    ++$i;
  }
}





function randomSelect($num, $cur_url){
  $return_v = array();
  
  $cur_path = decodeUrlVar($cur_url, "path");
  $name     = explode('.', $cur_path)[0];
  if(strpos($name, '/') !== false){
    $name = explode('/', $name);
    $name = end($name);
  }
  echo "
    <a class='list-group-item list-group-item-action active' m_path='$cur_path' href='#'> 
      $name 
    </a> \n
  ";
  --$num;
  $return_v[] = $cur_path;
  
  require_once "login2.php";
  $conn = get_connection();

  $query = "SELECT DISTINCT(Name), musicStoredPath FROM Music ORDER BY rand() LIMIT $num";
  if(!$result = $conn->query($query)){
    echo "Failed to load musics ".$conn->error;
    return;
  }

  
  while($row = $result->fetch_assoc()){
    $name       = pathinfo($row['Name'], PATHINFO_FILENAME);
    $return_v[] = $row['musicStoredPath'];
    echo "
      <a class='list-group-item list-group-item-action' m_path='{$row['musicStoredPath']}' href='#'> 
        $name 
      </a> \n
    ";
  }
  $result->free();
  $conn->close();

  return $return_v;
}

?>
