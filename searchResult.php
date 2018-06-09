

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title> MUlody Project </title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src='js/document_ready.js'></script>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ padding-top: 70px; }
    </style>
  </head>

  <body>
    <div id="HEADER"></div>
    <div class="container-fluid row">
      <div class="col-md-11 col">
        <?php outputResult(); ?>
      </div>
    </div><!-- End of container-fluid -->
  </body>
</html>

<?php

function outputResult(){
  include "php/GetMusicInfo.php";  
  
  $mid = getMid();
  if(empty($mid)){
    echo "<p class='text-muted'> No result. </p>";
    return;
  }
  
  foreach($mid as $id){
    $name     = getMusicName($id);
    $uploader = getUploader($id);
    $viewed   = getViewedNum($id);
    $desc     = getDescription($id);
    $date     = getUploadDate($id);
    $tag      = getTag($id);
    $path     = getPath($id);
    
    $name = pathinfo($name, PATHINFO_FILENAME);
    
    
    echo "
    <a href='./musicPlayer.php?path=$path' style='text-decoration:none;'>
      <div class='card container-fluid mb-2 text-dark'>
        <div class='card-body row'>
          <img src='image/single_note.png' class='mx-auto mb-1' style='width: 200px; height: 200px; background-color: rgba(220,255,186,0.5);'>
        
          <div class='col-md-4'>
            <h5 class='card-title'> $name </h5>
            <p class='card-text'> Viewed: $viewed</p>
            <p class='card-text'> Uploaded by $uploader</p>
            <p class='card-text'> Upload date: $date </p>
          <h5>";
    foreach($tag as $t) echo "  
            <span class='badge badge-info'> $t </span>";
    echo "</h5>
          </div>
          <div class='col-md'>
            <p class='card-text'> $desc </p>
          </div>
        </div><!-- End of card-body -->
      </div><!-- End of card -->
    </a>
    ";
  }
}

function getMid(){
  include "php/searchEngine.php";

  $str = $_GET['search_str'];
  $mid = search($str);

  return $mid;
}


?>





