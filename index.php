<?php
include_once "php/user.php";
cSessionStart();

if (isset($_GET["error"]))
{
    //todo error modal
}
?>

<!DOCTYPE html>
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--snap stuff-->
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-touch-fullscreen" content="yes">
  <link rel="stylesheet" type="text/css" href="snap/snap.css" />

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

  <!-- Material-Design icon library -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Bootstrap Core Stylesheet -->
  <link rel="stylesheet" href="bootstrap-material-design/css/bootstrap.min.css">

  <!-- Material-Design core stylesheet -->
  <link rel="stylesheet" href="bootstrap-material-design/css/mdb.min.css">

  <!-- My Stylesheet -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
<div class="snap-drawers">
  <div class="snap-drawer snap-drawer-right">
    <div>
      <ul>
        <li>Orders</li>
        <li>Listings</li>
        <li>Messages</li>
        <li>Notifications</li>
        <li>Account</li>
      </ul>
    </div>
  </div>
</div>

<!--login modal-->
<div class="modal fade" id="loginModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title w-100" id="myModalLabel">Login</h4>
      </div>
      <!--Body-->
      <div class="modal-body">
        <div class="md-form">
          <i class="fa fa-envelope prefix"></i>
          <input type="text" id="uemail" class="form-control">
          <label for="uemail">Your email</label>
        </div>

        <div class="md-form">
          <i class="fa fa-lock prefix"></i>
          <input type="password" id="upass" class="form-control">
          <label for="upass">Your password</label>
        </div>
      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" id="registrationBtn" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#registrationModal">Register</button>
        <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--/.login modal-->
<!--registration modal-->
<div class="modal fade" id="registrationModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title w-100" id="myModalLabel">Registration</h4>
      </div>
      <!--Body-->
      <div class="modal-body">
		<div class="md-form">
          <input type="text" id="username" class="form-control">
          <label for="form2">Username</label>
        </div>

        <div class="md-form">
          <input type="email" id="email" class="form-control">
          <label for="form4">Email</label>
        </div>

        <div class="md-form">
          <input type="password" id="password" class="form-control">
          <label for="form4">Password</label>
        </div>

        <div class="md-form">
          <input type="password" id="passwordConfirm" class="form-control">
          <label for="form4">Confirm Password</label>
        </div>
      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
        <button type="button" class="btn btn-primary" id="registerBtn">Submit</button>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--/.login modal-->

<div id="content" class="snap-content">
  <header>
    <!-- navbar -->
    <nav class="navbar navbar-dark navbar-fixed-top elegant-color-dark">
      <a href="#" id="open-left" class="navbar-brand">LOGO</a>
      <ul class="nav navbar-nav pull-right">
        <!--<li class="nav-item">-->
        <!--<a class="nav-link">Login</a>-->
        <!--</li>-->

          <?php
          if (loginCheck())
          {
              echo '
                    <li class="nav-item">
                        <a href="#" id="open-right" class="nav-link"><i class="material-icons">account_circle</i></a>
                    </li>';
          }
          else
          {
              echo '
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal"
			data-target="#loginModal"><i class="material-icons">lock</i></a>
                    </li>';
          }
          ?>
      </ul>
    </nav>
    <!--/.navbar -->
  </header>


  <!-- background image -->
  <div class="view hm-black-strong search-jumbotron">
    <div class="full-bg-img flex-center">
      <!--Search Bar-->
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <form>
          <input class="form-control" type="text" placeholder="Search">
        </form>
      </div>
      <div class="col-md-2"></div>
      <!--/.Search Bar-->
    </div>
  </div>
  <!--/.background image -->

  <main>
    <!--Item-Carousel-->
    <div class="container">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <div id="ItemCarousel" class="carousel slide" data-ride="carousel">
            <!--Indicators-->
            <ol class="carousel-indicators">
              <li data-target="#ItemCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#ItemCarousel" data-slide-to="1"></li>
              <li data-target="#ItemCarousel" data-slide-to="2"></li>
            </ol>
            <!--/.Indicators-->

            <!--Slides Wrapper-->
            <div class="carousel-inner " role="listbox">
              <div class="carousel-item active">
                <div class="row">
                  <div class="col-xs-4 item-card"> </div>
                  <div class="col-xs-4 item-card"> </div>
                  <div class="col-xs-4 item-card"> </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="row">
                  <div class="col-xs-4 item-card"> </div>
                  <div class="col-xs-4 item-card"> </div>
                  <div class="col-xs-4 item-card"> </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="row">
                  <div class="col-xs-4 item-card"> </div>
                  <div class="col-xs-4 item-card"> </div>
                  <div class="col-xs-4 item-card"> </div>
                </div>
              </div>
            </div>
            <!--/.Slides Wrapper-->
          </div>
        </div>
        <div class="col-md-1"></div>
      </div>
    </div>
    <!--/.Item-Carousel-->
  </main>

  <footer>

  </footer>
</div>

<!--Scripts-->
<script src="bootstrap-material-design/js/jquery-3.1.1.min.js"></script>
<script src="bootstrap-material-design/js/tether.min.js"></script>
<script src="bootstrap-material-design/js/bootstrap.min.js"></script>
<script src="bootstrap-material-design/js/mdb.min.js"></script>
<script src="js/cards.js"></script>
<script src="js/login.js"></script>

<script type="text/javascript" src="snap/snap.min.js"></script>
<script type="text/javascript">
    var snapper = new Snap({
        element: document.getElementById('content')
    });
</script>
<!--/.Scripts-->
</body>
