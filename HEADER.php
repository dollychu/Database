
<?php session_start() ?>

<nav class="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #E3F2FD;">
  <div class="ml-1 container-fluid row">
    <div class="navbar-header col-md-1 row justify-content-between">
      <a class="navbar-brand" href='./'> MUlody</a>
      <button type='button' class="navbar-toggler" data-toggle='collapse' data-target='#navbarsMain' aria-controls='navbarsMain' aria-expanded='false'>
        <span class='navbar-toggler-icon'></span>
      </button>
    </div><!--./navbar-header-->

    <div class="collapse navbar-collapse col-md-11" id="navbarsMain">
      <div class="container-fluid row" >
        <ul class="navbar-nav col-md-1">
          <li class="nav-item active"><a class="nav-link" href="./">HOME<span class="sr-only">(current)</span></a></li>
        </ul>

        <form class="form-inline col-md-4 ml-auto" type='search'>
          <div class="container row justify-content-center">
            <div class="col-8-fluid"><input class="form-control" type="text" placeholder="Search"></div>
            <div class="col-4-fluid"><button class="btn btn-default ml-sm-2" type="submit">GO</button></div>
          </div>
        </form>
            
        <ul class="navbar-nav col-md-3 ml-md-auto">
          <div class="row">
            <div class="col-md"><li class="nav-item"><a class="nav-link" href="upload.php">UPLOAD</a></li></div>
            <div class="col-md-fluid ml-1"><li class="nav-item">
              <?php
                if(isset($_SESSION['UserName'])){
                  echo "<a class='nav-link' href='settings.php'>".$_SESSION['UserName']."</a>";
                }
                else{
                  echo "<a class='nav-link' href='sign_in.php'>SIGN IN</a>";
                }
              ?>
            </li></div>
            <div class="col-md">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   ELSE
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">About us</a>
                    <a class="dropdown-item" href="./settings.php">Settings</a>
                    <div class='dropdown-divider'></div>
                    <a class="dropdown-item" href="php/logout.php">Sign out</a>
                </div>
              </li>
            </div>
          </div>
        </ul>
        
      </div><!--End of inner row-->
    </div><!--End of collapse navbar-->
  </div><!-- ./container-fluid -->
</nav>

