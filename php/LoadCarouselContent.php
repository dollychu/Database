<?php

require_once "login2.php";

PrintHTML();

function PrintHTML(){
  $selected  = randMusic($max_in_carousel=7);
  $selected += chooseMusic($num_tag_select=5, $min_music_num=0, $max_in_carousel=7);
  

  foreach($selected as $tag => $musics){
    $next_avail = count($musics) > 3 ? "" : "disable";
    echo "
      <div class='container-fluid'>
        <h4><span class='badge badge-light ml-3'> $tag </span></h4>
        <div class='carousel slide mb-2' data-interval='false' data-ride='carousel' id='slide_$tag'>
          <div class='carousel-inner row mx-auto'>";
            PrintInnerCard($musics);
    echo "</div>
          
          <a class='carousel-control-prev disable' href='#slide_$tag' role='button' data-slide='prev'>
            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
            <span class='sr-only'>Previous</span>
          </a>
          <a class='carousel-control-next $next_avail' href='#slide_$tag' role='button' data-slide='next'>
            <span class='carousel-control-next-icon' aria-hidden='true'></span>
            <span class='sr-only'>Next</span>
          </a>
        </div><!--End of carousel slide-->
      </div><!--End of container-->";
  }
  
  echo "<script src='../js/carousel_control.js'></script>";
}

function PrintInnerCard($musics){
  require_once "GetMusicInfo.php";
  
  $i = 0;
  foreach($musics as $music){
    $name     = pathinfo($music['Name'], PATHINFO_FILENAME);
    $path     = $music['MusicStoredPath'];
    $id       = $music['IdMusic'];
    $viewed   = getViewedNum($id);
    $uploader = getUploader($id);
    $date     = getUploadDate($id);
    
    if($i == 0) echo "<div class='carousel-item col-md-4 active'>";
    else echo "<div class='carousel-item col-md-4'>";
    echo <<< _END
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
_END;
    $i += 1;
  }
}

function randMusic($max_in_carousel=7){
  $conn  = get_connection();
  $query = "SELECT * FROM Music ORDER BY rand() LIMIT $max_in_carousel";
  
  if(!$result = $conn->query($query)){
    echo $conn->error;
    $conn->close();
    return 0;
  }
  
  $v = array();
  while($tmp = $result->fetch_assoc()){
    $v[] = $tmp;
  }
  $return_v['Recommend'] = $v;
  
  $result->free();
  $conn->close();
  return $return_v;
}
function chooseMusic($num_tag_select=5, $min_music_num=1, $max_in_carousel=7){
  $NUM   = $num_tag_select;
  $MIN   = $min_music_num;
  $conn  = get_connection();
  $query = "SELECT DISTINCT(TagName)
            FROM ( SELECT TagName
                   From Tag
                   GROUP BY TagName
                   HAVING COUNT(TagName) > $MIN) as TEMP
            ORDER BY rand() 
            LIMIT $NUM";

  if(!$result = $conn->query($query)){
    echo $conn->error;
    $conn->close();
    return 0;
  }
  
  $stmt = $conn->stmt_init();
  $query = "SELECT * 
            FROM Music 
            WHERE IdMusic IN( SELECT IdMusic
                              FROM Tag
                              WHERE TagName=? )
            ORDER BY rand()
            LIMIT $max_in_carousel";
  if(!$stmt->prepare($query)){
    echo $stmt->error;
    $result->free();
    $stmt->close();
    $conn->close();
    return 0;
  }

  $stmt->bind_param('s', $name);
  $return_v = array();
  while($name = $result->fetch_row()){
    $name = $name[0];
    $stmt->execute();
    $id = $stmt->get_result();
    $v  = array();
    while($tmp = $id->fetch_assoc()){
      $v[] = $tmp;
    }
    $return_v[$name] = $v;
    $id->free();
  }

  $result->free();
  $stmt->close();
  $conn->close();
  return $return_v;
}

?>
