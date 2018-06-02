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
        if (results==null){
           return null;
        }
        else{
           return results[1] || 0;
        }
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
        <div class="col-md-6">
          <div class="card">
            <h5><div class="card-header text-center" id="audioCardTitle"></div></h5>
            <img class="card-img-top mx-auto mt-3" src="image/earphone.png" style="width: 200px;">
            <div class='card-body'>
              <audio controls id="audioPlayer" class="col" style="height: 50px;">
                <source src="" type="audio/mpeg" id="playingAudio">
              Your browser does not support the audio element.
              </audio>
			  
			  <button type="button" class="text-small" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id="commentBtn">
				comment
			  </button>
			  <!--comment-button-->
            
			</div>
			<script>
				$("#commentBtn").click(function(){
					var islogin = <?php echo isset($_SESSION['IdUser']); ?>;
					$(this).val(islogin);
				});
			</script>
          </div><!--End of card-->
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
					  <!--commentator-name is the var to get the User.name-->
					</div>
				    <div class="form-group">
					  <label for="message-text" class="col-form-label">Message:</label>
					  <textarea class="form-control" id="message-text"></textarea>
				    </div><!--End of form-group-->
				  <div class="modal-footer">
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				    <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
				  </div><!--End of modal_footer-->
			    </div><!--End of modal-body-->
			  </div><!--End of modal-content-->
		    </div><!--End of modal-dialog-->
		  </div><!--End of modal-->
  </body>
</html>