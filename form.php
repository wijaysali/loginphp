<?php
  session_start();
  if(isset($_SESSION['username'])) {
    header("Location:index.php");
  } else {
    include 'config.php';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Membuat login</title>
    <link rel="stylesheet" href="bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <form method="post" action="proseslogin.php">
          <div class="form-group"><br>
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="checkbox">
            <label class="checkbox">
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </div>
  </body>
</html>
