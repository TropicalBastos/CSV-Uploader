<?php

if(isset($_SESSION)){
    header("Location: /account/dashboard.php");
    die();
  }

if(!isset($_POST['user'])
|| !isset($_POST['pass'])
|| !isset($_POST['passconfirm'])){
    header("Location: /routes/registerpage.php?error=failed");
    die();
}

require("../constants.php");

$user = $_POST['user'];
$pass = $_POST['pass'];
$confirm = $_POST['passconfirm'];

if(strlen($user) > 5
|| strlen($pass) > 5
|| $pass == $confirm){
    $conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);
    $query = "SELECT * FROM Users WHERE username='$user'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
        header("Location: /routes/registerpage.php?error=exists");
        die();
    }
    $hashed = md5($pass);
    $query = "INSERT INTO Users (username,password) VALUES('$user','$hashed');";
    $result = $conn->query($query);
    $query = "CREATE TABLE $user " . DATA_TABLE;
    $result = $conn->query($query);
    if(!$result){
        header("Location: /routes/registerpage.php?error=failed");
        die();
    }else{
        session_start();
        $_SESSION['user'] = $user;
        header("Location: /account/dashboard.php");
    }
}else{
    header("Location: /routes/registerpage.php?error=failed");
}

?>