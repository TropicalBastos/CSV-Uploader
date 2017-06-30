<?php

if(!isset($_SESSION)){
    session_start();
}

require("../constants.php");

if(!isset($_SESSION['user'])){
    die();
}

if(!isset($_GET['id'])){
    die();
}else{
    $id = $_GET['id'];
    $query = "SELECT * FROM " . $_SESSION['user'] . " WHERE id=$id;";
    $conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);
    $result = $conn->query($query);
    if(!$result){
        die();
        header("HTTP/1.0 404 Not Found");
    }
    if(($row = $result->fetch_row()) != null){
        echo json_encode($row);
    }else{
        header("HTTP/1.0 404 Not Found");
    }
}

?>