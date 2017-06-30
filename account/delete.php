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
    header("Location: /account/dashboard.php?delete=all");

}else{

    header("Location: /account/dashboard.php");

}

?>