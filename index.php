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
        <link rel='stylesheet' href='css/carousel_style.css'>
        <style>
            body{ padding-top: 70px; }
        </style>
        
    </head>

    <body>
      <div id='HEADER'></div>
      
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-sm-8 mb-2'>
            <?php require_once "php/LoadCarouselContent.php"; ?>
          </div><!--End of Col-sm-8-->

          <div class='col-sm-4'>
            <div class='card'>
              <h6 class='card-header'> Other things </h6>
              <div class='card-body'>
                <h5> blablabla </h5>
                <p> blablabla </p>
                <p>hahahahahahahacheow</p>
              </div>  
            </div> 

          </div><!--End of Col-sm-4-->
        </div><!--End of Row-->
      </div><!--End of Container-fluid-->
    </body>
</html>

