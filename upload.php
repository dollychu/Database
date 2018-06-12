<?php $_SESSION['MSG'] = "Please login first."; ?>
<?php include "php/checkLogin.php"; ?>


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
    <link href="css/fileupload.css" rel="stylesheet">
    <style>
        body{ padding-top: 70px; }
    </style>
  </head>

  <body>
    <div id='HEADER'></div>
    <div class="container-fluid row justify-content-center">
      <form class="col-md-7" action="upload.php" enctype="multipart/form-data" method="POST">
       
        <div class="accordion mb-2" id="optionalInfo">
          <div class="card">
            <div class="card-header" id="opt_description">
              <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#upload" aria-expanded="true" aria-controls="upload">
                  Upload
                </button>
              </h5>
            </div>
            <div id="upload" class="collapse show" aria-labelledby="opt_pload" data-parent="#optionalInfo">
              <div class="card-body row justify-content-center">
                <input type="text" class="form-control col-md-8 mr-2" value="selected file..." disabled id="selectedFile">
                <span class="align-middle">
                  <label for="uploadfile" class="custom-file-upload mt-2">
                    Select File
                  </label>
                </span>
                <input type="file" class="btn required" name="uploaded_file" id="uploadfile">
              </div><!-- End of card-body -->
            </div>
          </div><!-- End of card -->
          <div class="card">
            <div class="card-header" id="opt_description">
              <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#description" aria-expanded="true" aria-controls="description">
                  Description
                </button>
              </h5>
            </div>
            <div id="description" class="collapse" aria-labelledby="opt_description" data-parent="#optionalInfo">
              <div class="card-body">
                <textarea class="form-control" aria-label="Description" name="description"></textarea>
              </div><!-- End of card-body -->
            </div>
          </div><!-- End of card -->

          <div class="card">
            <div class="card-header" id="opt_tag">
              <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tag" aria-expanded="true" aria-controls="tag">
                 Tag 
                </button>
              </h5>
            </div>
            <div id="tag" class="collapse" aria-labelledby="opt_tag" data-parent="#optionalInfo">
              <div class="card-body">
                <div class="input-group mb-1">
                  <input type="text" class="form-control" id="tagInput"> 
                  <div class="input-group-append">
                    <span class="btn input-group-text btn-outline-secondary add-tag">+</span>
                  </div>
                </div>
                <h5 id="tags"></h5>
              </div><!-- End of card-body -->
            </div>
          </div><!-- End of card -->
        </div><!-- End of accordion -->

        <input type="submit" class="btn btn-primary" value="Upload">
      </form>
      <script>
        $('#uploadfile').bind('change', function() { 
          var fileName = ''; 
          fileName = $(this).val().split('\\'); 
          $('#selectedFile').attr("value", fileName[fileName.length-1]); 
        });
        
        $(document).on('click', '.remove-me', function(){
          var input_val = $(this).text();
          $(this).remove();
          $('input[value='+input_val+']').remove();
        });
        $('.add-tag').click(function(){
          var tag = $("#tagInput").val();
          tag = tag.replace(/\ /g, '');
          $('#tags').append("<span class='btn badge badge-info mr-1 remove-me'>"+tag+"</span>");
          $('#tags').append("<input type='text' class='hidden' name='tags[]' value='"+tag+"'>");
          $('#tagInput').val('');
          var se = $('form').serialize();
        });
        $('form').submit(function(event){
          if($('input.required').val().length === 0){
            alert("Please select a file to upload!");
            event.preventDefault();
          }
        });
      </script>
    </div><!-- End of container-fluid -->
  </body>
</html>

<?php
  session_start();
  
  if(isset($_SESSION['IdUser']) && !empty($_FILES['uploaded_file']))
  {
    $path = "Music/".$_SESSION['UserName'];
    if(!is_dir($path)){
      if(!mkdir($path, 0777, true)){
        echo "Failed to create new folder.";
      }
    }

    $audio_name = basename($_FILES['uploaded_file']['name']);
    $path = $path ."/" .$audio_name;
    
    $avail_fmt = array("audio/mp4", "video/mp4", "audio/mpeg", "audio/ogg", "application/octet-stream");
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['uploaded_file']['tmp_name']);
    if(false === array_search($mime, $avail_fmt, true)){
      ALERT("File format not supported: ".$mime);
      return 0;
    }
    else if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      if(!updateDB($audio_name)){
        ALERT("There was an error when updating the DB!");
        return 0;
      }
      chmod($path, 0731);
      ALERT($audio_name." has been uploaded");
    } 
    else{
      switch($_FILES['upfile']['error']){
        case UPLOAD_ERR_OK:
          ALERT("Upload ok, but fail at other place");
          break;
        case UPLOAD_ERR_NO_FILE:
          ALERT("No file sent.");
          break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
          ALERT("Exceeded filesize limit.");
          break;
        default:
          ALERT("Unknown errors.");
      }
    }
  }
  function updateDB($audio_name){
    require_once "php/login2.php";

    $conn = get_connection();
    $stmt = $conn->stmt_init();
    $query = "INSERT INTO Music(Name, UploadUser, MusicStoredPath, Description) VALUES('$audio_name', {$_SESSION['IdUser']}, ?, ?)";
    if(!$stmt->prepare($query)){
      ALERT("Failed to prepare query!");

      $stmt->close();
      $conn->close();
      return 0;
    }

    $stmt->bind_param("ss", $path, $description);
    $path = "{$_SESSION['UserName']}/$audio_name";
    $description = isset($_POST['description']) ? $_POST['description'] : "";
    if(!$stmt->execute()){
      ALERT("Failed to update database!");

      $stmt->close();
      $conn->close();
      return 0;
    }
    $mid = $stmt->insert_id;
    $stmt->close();
    
    // Insert tags
    if(isset($_POST['tags'])){
      $query = "INSERT INTO Tag(TagName, IdUser, IdMusic) VALUES(?, {$_SESSION['IdUser']}, $mid)";
      $stmt = $conn->stmt_init();
      $tmp = $stmt->prepare($query);
      $stmt->bind_param('s', $tag);
      $tags = $_POST['tags'];
      foreach($tags as $tag){
        $stmt->execute();
      }
      $result->free();
      $stmt->close();
    }
    
    // Update user data
    $updateTime = date("Y-m-d H:i:s");
    $query = "UPDATE User SET UpdateAt='$updateTime' WHERE IdUser={$_SESSION['IdUser']}";
    $conn->query($query);
    
    
    $conn->close();

    return 1;
  }
  function ALERT($msg){
    echo "<script> alert('$msg'); </script>";
  }
?>
