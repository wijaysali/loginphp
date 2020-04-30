# loginphp
Form Login dengan PHP &amp; MySQL



Tutorial login ini di buat menggunakan PHP dan MYSQL

Langkah - langkah dalam pembuat login pada php dan mysql adalah

Kamu masukan databasenya terlebih dahulu, Database sudah disiapkan sql-Nya dengan nama login.sql, tinggal import aja.

Hal pertama yang haruskamu pelajari adalah koneksikan mysql ke php, kamu bisa lihat ke config.php

Kamu harus mempelajari, cara membuat form. penting Yang harus kamu perhatikan jika membuat form adalah form action, method post atau get dan name dari input text tersebut, kamu bisa lihat di form.php

kamu pelajari proses_login.php, di situ kamu bisa mempelajari "bagaimana cara proses masuk (login) atau cara kerjanya.
index.php adalah di mana keadaan kamu sudah login, yang kamu perhatikan adalah session, time out jika ingin otomatis keluar sendiri yang timernya sudah di atur.
logout.php yang mana, jika kamu ingin keluar tidak akan bisa balik lagi, jadi kalau kamu mau balik lagi, kamu harus masukan kembali username dan password. Selamat Mencoba!! 


Database : Login
Table       : admin

-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(12) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `username`, `password`, `fullname`) VALUES
(1, 'fwdb', '123456', 'workshop fwdb');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

Kita buat 5 file, apa saja ya ?
config.php
form.php
proseslogin.php
index.php
logout.sql
Mari kita coding satu - persatu ya

config.php = Ini untuk mengkoneksikan mysql ke php

<?php
    mysql_connect("localhost", "root", "");
    mysql_select_db("login");
?>

form.php = ini untuk form login

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

proseslogin.php = ini adalah proses untuk login

<?php
    include 'config.php';
    date_default_timezone_set("Asia/jakarta");

    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    if(empty($username) && empty($password))  {
        header("Location:form.php?error1");
        break;
    } else if(empty($username)) {
      header("Location:form.php?error2");
      break;
    } else if(empty($password)) {
      header("Location:form.php?error3");
      break;
    }

    $q = mysql_query("SELECT * FROM admin WHERE username = '$username' and password = '$password'");
    $row = mysql_fetch_array($q);

    if (mysql_num_rows($q) == 1) {
     $_SESSION['username'] = $username;
     $_SESSION['fullname'] = $row['fullname'];
        header("Location:index.php");
    } else {
      header("location:form.php?error4");
    }
?>

index.php = Ini jika kamu sukses login

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

logout.php = ini untuk kamu keluar setelah kamu login, dan jika kamu ingin masuk lagi, kamu harus login kembali.

<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda telah berhasil keluar.'); window.location = 'index.html'</script>"; 
?>
























