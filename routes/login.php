<?php

if(!isset($_SESSION)){
    session_start();
}

require("../constants.php");

$user = $_POST['user'];
$pass = $_POST['pass'];

function checkUser($u, $p){

    $hash = md5($p);

    $db = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB)
          or die('Error connecting to MySQL server.');
    $query = "SELECT * FROM Users WHERE username='" . $u . "' AND password='" . $hash . "'";
    $result = $db->query($query);

    if(!$result){
        $_SESSION['loginfailed'] = "failed";
        header("Location: ../index.php");
    }else{
        if($result->num_rows > 0){
            $row = $result->fetch_row();
            $_SESSION['user'] = $row[1];
            header("Location: /account/dashboard.php");
        }else{
            $_SESSION['loginfailed'] = "failed";
            header("Location: ../index.php");
        }
    }

}

checkUser($user, $pass);

?>