<?php 

   require("constants.php"); 

   if(!isset($_SESSION)){
    session_start();
    }

    if(isset($_GET['logout'])){
        session_destroy();
        $_SESSION = [];
    }

   if(!isset($_SESSION['user'])){

    require(ROOT . "/routes/loginpage.php");

    //unset variable so as to not keep reproducing username error in view
    if(isset($_SESSION['loginfailed'])){
       unset($_SESSION['loginfailed']);
    }

   }else{

    header("Location: /account/dashboard");

   }

?>