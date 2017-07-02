<?php

if(!isset($_SESSION)){
    session_start();
  }

  require("../constants.php");

if(!isset($_SESSION['user'])){
  header("Location: ../index.php");
}

if(isset($_GET['deleteall'])){

    $query = "TRUNCATE " . $_SESSION['user'] . ";";
    $conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);
    $conn->query($query);
    $_SESSION['delete'] = "all";
    header("Location: /account/dashboard.php");

}else{

    header("Location: /account/dashboard.php");

}

?>