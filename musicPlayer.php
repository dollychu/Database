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
        else return results[1] || 0;
      }
      
      $(document).ready(function(){
        var hrefVar=decodeURI($.urlParam('path'));
        var full="Music/"+hrefVar;
        $('#playingAudio').attr("src", full).detach().appendTo("#audioPlayer");
        
        var title = hrefVar.split('/');
        title = title[title.length-1];
        $('#audioCardTitle').text(title.slice(0,-4));
      });
      
      
    </script>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body{ padding-top: 70px; }
    </style>
  </head>
  
  
  <body>
    <div id="HEADER"></div>
    <div class='container'>
      <div class="row justify-content-around">
        <div class="col-md-8">
          <?php include "php/playerPane.php"; ?>
          <?php include "php/loadComment.php"; ?>
        </div><!-- End of col -->
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
  <script>
    var played = false;
    $("#audioPlayer").on('play', function(){
      var path = decodeURI($.urlParam('path'));
      if(!played){
        played = true;
        $.post("php/increaseMusicViewedNum.php", { music_path: path })
          .done(function(data){
            //alert(data); // To debug, uncomment this line
          })
          .fail(function(jqXHR, textStatus){
            alert("There is something wrong updating the viewed num: "+textStatus);
          });
      }
    });
    
    $("#commitCmt").click(function(){
        var cmt = $("#cmtMSG").val();
        var music = decodeURI($.urlParam('path'));
        $.post("php/insertMusicComment.php", { comment: cmt, music_path: music })
          .done(function(last_id){
            $("#playerPane").after($.cardTemplate(cmt, last_id));
            $("#comment_"+last_id).hide().fadeIn(1200);
            $("#cmtMSG").val('');
          })
          .fail(function(jqXHR, textStatus ){
            alert('fail' + textStatus);
          });
      });
      $.cardTemplate = function(text, id){
        var user_name = "<?php echo $_SESSION['UserName']; ?>";
        return "<div class='card mb-1' id='comment_"+ id +"'>\
                  <div class='card-header'>"+ user_name +"</div>\
                  <div class='card-body'>\
                    <p class='card-text'>" + text + "</p>\
                  </div>\
                </div>";
      };
  </script>
</html>



