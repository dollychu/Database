<?php include "php/checkLogin.php"; ?>
<?php $_SESSION['MSG'] = "Please login first."; ?>


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
    <div class="container-fluid"><div class="row justify-content-center">
      <form class="col-md-5" action="upload.php" enctype="multipart/form-data" method="POST">
        
        <!--span class="btn btn-success fileinput-button">
          <span>Select file</span>
          <input id="fileupload" name="uploaded_file" type="file" mutiple="">
        </span>
        <div id="progress" class="progress">
          <div class="progress-bar progress-bar-success"></div>
        </div>
        <div id="files" class="files"></div-->
        
        <div class="form-row align-middle mb-1">
          <input type="text" class="col-md-8 mr-2" value="selected file..." disabled id="selectedFile">
          <span class="align-middle">
          <label for="uploadfile" class="custom-file-upload mt-2">
            Select File
          </label>
          <span>
          <input type="file" class="btn" name="uploaded_file" id="uploadfile">
        </div>
        
        <input type="submit" class="btn btn-primary" value="Upload">
        
      </form>
      <script>
        $('#uploadfile').bind('change', function() { 
          var fileName = ''; 
          fileName = $(this).val().split('\\'); 
          $('#selectedFile').attr("value", fileName[fileName.length-1]); 
        });
      </script>
    </div></div>
    
    <!--script src="js/jquery.ui.widget.js"></script>
    <script src="js/jquery.uploadfile.js"></script>
    <script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === 'localhost' ? 'php/upload.php' : '//jquery-file-upload.appspot.com/';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
    </script-->
    
    
    
  </body>
</html>

<?php
  session_start();
  if(isset($_SESSION['IdUser']) && !empty($_FILES['uploaded_file']))
  {
    $path = "Music/".$_SESSION['UserName'];
    if(!is_dir($path)) mkdir($path, 0777, true);

    $audio_name = basename($_FILES['uploaded_file']['name']);
    $path = $path ."/" .$audio_name;

    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      if(!updateDB($audio_name)){
        ALERT("There was an error when updating the DB!");
        return 0;
      }
      ALERT($audio_name." has been uploaded");
    } 
    else{
      ALERT("There was an error uploading the file, please try again!");
    }
  }
  function updateDB($audio_name){
    require_once "php/login2.php";

    $conn = get_connection();
    $stmt = $conn->stmt_init();
    $query = "INSERT INTO Music(Name, UploadUser, MusicStoredPath) VALUES('$audio_name', {$_SESSION['IdUser']}, ?)";
    if(!$stmt->prepare($query)){
      ALERT("Failed to prepare query!");

      $stmt->close();
      $conn->close();
      return 0;
    }

    $stmt->bind_param("s", $path);
    $path = "{$_SESSION['UserName']}/$audio_name";

    if(!$stmt->execute()){
      ALERT("Failed to update database!");

      $stmt->close();
      $conn->close();
      return 0;
    }
    
    $stmt->close();
    $conn->close();

    return 1;
  }
  function ALERT($msg){
    echo "<script> alert('$msg'); </script>";
  }
?>
