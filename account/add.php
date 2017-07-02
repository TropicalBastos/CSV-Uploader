<?php

if(!isset($_SESSION)){
    session_start();
  }

if(!isset($_SESSION['user'])){
  header("Location: ../index.php");
}

require("../constants.php");

$conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);
if(!$conn){
    addError();
}

$first = $_POST['first'];
$last = $_POST['last'];
$company = $_POST['company'];
$profession = $_POST['profession'];
$chapter = $_POST['chapter'];
$phone = $_POST['phone'];
$altphone = $_POST['altphone'];
$cell = $_POST['cell'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$website = $_POST['website'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$sub = $_POST['substitute'];
$status = $_POST['status'];
$join = $_POST['join'];
$sponsor = $_POST['sponsor'];

$query = "INSERT INTO " . $_SESSION['user'] . " (firstname,lastname,company,profession,chaptername,phone,
altphone,fax,mobile,email,website,address,city,state,zip,substitute,status,joindate,renewal,sponsor) 
VALUES('$first','$last','$company','$profession','$chapter',
'$phone','$altphone','$fax','$cell','$email','$website','$address','$city','$state','$zip','$sub','$status',
'$join','','$sponsor')";

$result = $conn->query($query);
if(!$result){
    addError();
}else{
    success();
}

function addError(){
    $_SESSION['add_error'] = true;
    header("Location: /account/dashboard.php");
}

function success(){
    $_SESSION['added'] = true;
    header("Location: /account/dashboard.php");
}

?>