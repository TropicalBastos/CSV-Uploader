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

    $conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);
    foreach($_POST as $key => $value){
        $query = "DELETE FROM " . $_SESSION['user'] . " WHERE id=" . $value . ";";
        $result = $conn->query($query);
        if(!$result){
            header("HTTP/1.0 404 Not Found");
        }else{
            header("HTTP/1.0 200 OK");
            $_SESSION['deleted'] = "record";
        }
    }

}

?>