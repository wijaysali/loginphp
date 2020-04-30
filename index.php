<?php
  session_start();
  if(empty($_SESSION['username'])) {
    header("Location:form.php");
  } else {
    include 'config.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Membuat dashboard login</title>
    <link rel="stylesheet" href="bootstrap.min.css">
  </head>
  <body>
    <!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Login Admin</a>
          </div>
              <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li>
                      <a href="#" class="active"><span class="glyphicon glyphicon-user"></span>
                          <?php
                            echo $_SESSION['fullname'];
                          ?>
                      </a>
                  </li>
                </ul>
              </div><!--/.nav-collapse -->
        </div>
  </div>

<?php
  $timeout = 10;
  $logout_redirect_url = "form.php"; // Set logout url

  $timeout = $timeout * 60;
  if(isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if($elapsed_time >= $timeout) {
      session_destroy();
      echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
    //  echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";

    }
  }
  $_SESSION['start_time'] = time();
?>
  <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Selamat, Anda Berhasil Login.!<br/><?php $fullname = $_SESSION['fullname']; echo $fullname; ?></h1>
        <p>
          <a class="btn btn-lg btn-primary" href="logout.php" onclick="return confirm('Apakah anda akan keluar?');">Keluar »</a>
        </p>
      </div>
  </div> <!-- /container -->
<?php } ?>
</body>
</html>
