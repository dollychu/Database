<?php session_start(); ?>
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
    
    <script>
      $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);
        if (results==null) return null;
        else results = results[1] || 0;
        if(results.search("&") != -1) results = results.split('&')[0];
        
        return results;
      }
      
      $(document).ready(function(){
        var hrefVar=decodeURI($.urlParam('path'));
        var full="Music/"+hrefVar;
        $('#playingAudio').attr("src", full).detach().appendTo("#audioPlayer");
        
        var title = hrefVar.split('/');
        title = title[title.length-1];
        $('#audioCardTitle').text(title.slice(0,-4));

        var isPlaying = $.urlParam('playing');
        if(isPlaying == 1) $("#audioPlayer")[0].play();
        
        var play_mode = $.urlParam('play_mode');
        if(play_mode != null){
          $('#ctrlBtn > label.active').removeClass('active');
          $('#'+play_mode).parent().addClass('active');
        }
      });
    </script>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body{ 
        padding-top: 70px; 
        background-image: url("./image/zen01.jpg");
      }
    </style>
  </head>
  
  
  <body>
    <div id="HEADER"></div>
    <div class='container-fluid'>
      <div class="row">
        <div class="offset-md-2 col-md-7">
          <?php include "php/playerPane.php"; ?>
          <?php include "php/loadComment.php"; ?>
        </div><!-- End of col -->
        <div class="col-md-3">
        
          <div class="row justify-content-center mr-1">
            <div class="btn-group btn-group-toggle mb-1" data-toggle="buttons" id="ctrlBtn">
              <label class="btn btn-outline-dark active">
                <input type="radio" name="options" id="once" autocomplete="off"> ONCE
              </label>
              <label class="btn btn-outline-dark">
                <input type="radio" name="options" id="loop" autocomplete="off"> LOOP
              </label>
            </div>
          </div>
          
          <ul class="list-group list-group-flush" id="playlist">
            <?php include "php/loadPlayList.php"; ?>
          </ul>
          
        </div>
      </div><!--End of row-->
        
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div><!--End of modal-header-->

            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="commentator-name" class="col-form-label">Commetator:</label>
                  <output type="text" class="form-controls" id="commentator-name">
                    <?php echo $_SESSION['UserName']; ?>
                  </output>
                </div>
                <div class="form-group">
                  <label for="message-text" class="col-form-label">Message:</label>
                  <textarea class="form-control" name="comment" id="cmtMSG"></textarea>
                </div><!--End of form-group-->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal" id="commitCmt">Save changes</button>
                </div><!--End of modal_footer-->
              </form>
            </div><!--End of modal-body-->
          </div><!--End of modal-content-->
        </div><!--End of modal-dialog-->
      </div><!--End of modal-->
    </div><!-- End of container -->
  </body>
  <script src="js/playlistAction.js"></script>
  <script src="js/leaveComment.js"></script>
</html>



