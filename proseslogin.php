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
