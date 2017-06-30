<?php

if(!isset($_SESSION)){
    session_start();
}

require("../constants.php");

if(isset($_FILES['file']['name'])){

    $file = $_FILES['file']['name'];

    if($_FILES['file']['error'] == 0){

        //check if it is a csv
        $pattern = "/^.*\.csv$/";
        if(!preg_match($pattern,$file)){
            $_SESSION['upload'] = "failed";
            header("Location: /account/dashboard.php");
        }

        if(uploadCsvToDatabase($_FILES['file']['tmp_name'])){
            $_SESSION['upload'] = "success";
        }else{
            $_SESSION['upload'] = "failed";
        }
        
        header("Location: /account/dashboard.php");

    }else{
        $_SESSION['upload'] = "failed";
        header("Location: /account/dashboard.php");
    }

}else{

    $_SESSION['upload'] = "failed";
    header("Location: /account/dashboard.php");

}

function uploadCsvToDatabase($filePath){

    $success = true;
    $affected_rows = 0;
    $conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);

    if(($handle = fopen($filePath,"r")) !== false){

        //no need for first line since the database already has the columns
        $columns = fgetcsv($handle, 1000, ",");
        if(count($columns) != 20) return;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            //check if record already exists by checking email
            $query = "SELECT * FROM " . $_SESSION['user'] . " WHERE email='$data[9]'";
            $result = $conn->query($query);
            if($result->num_rows > 0){
                    continue;
            }

            $num = count($data);
            $statement = "INSERT INTO " . $_SESSION['user'] .  " VALUES(";
            for ($c=0; $c < $num; $c++) {
                $data[$c] = utf8_encode($data[$c]);
                //escape apostrophes for query
                $data[$c] = preg_replace('/\'/','\'\'',$data[$c]);
                if($c == 0) $statement = $statement . "'$data[$c]'";
                $statement = $statement . ",'$data[$c]'";
            }
            $statement = $statement . ");";
            if(!$conn->query($statement)){
                $success = false;
            }else{
                $affected_rows = $affected_rows + mysqli_affected_rows($conn);
            }
            
        }
        fclose($handle);

    }

    $_SESSION['affected_rows'] = $affected_rows;
    return $success;

}

?>