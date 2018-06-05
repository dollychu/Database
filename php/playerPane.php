<?php

$url = $_SERVER['QUERY_STRING'];

require_once "GetMusicInfo.php";
$viewed = getViewedNum($url);
$uploader = getUploader($url);

$isLogin = isset($_SESSION['IdUser']) ? 1 : 0;

echo "

<div class='card mb-2' id='playerPane'>
  <h5><div class='card-header text-center' id='audioCardTitle'></div></h5>
  <img class='card-img-top mx-auto mt-3' src='image/earphone.png' style='width: 200px;'>
  <div class='card-body'>
    <audio controls id='audioPlayer' class='col' style='height: 50px;'>
      <source src='' type='audio/mpeg' id='playingAudio'>
    Your browser does not support the audio element.
    </audio>
    
    <p class='card-text text-muted col'> Viewed: ".$viewed."</p>
    <p class='card-text text-muted col'> Uploaded by ".$uploader."</p>

    <button type='button' class='btn btn-outline-primary btn-block mx-auto mt-3' data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo' id='commentBtn'>
      leave comment
    </button><!--comment-button-->
  </div><!-- End of card-body -->
  <script>
    $('#commentBtn').click(function(){
      var islogin = ".$isLogin.";
      if(!islogin){
        alert('You have not yet logged in! Please login first to leave a comment.');
        window.location.href = 'sign_in.php';
      }
    });
  </script>
</div><!--End of card-->

";


?>

