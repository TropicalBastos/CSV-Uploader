<?php 
if(!isset($_SESSION)){
    session_start();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css"/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
  </head>
  <body>

      <nav class="navbar">
        <span><i class="fa fa-sign-out"></i>   Logout</span>
      </nav>
      <h1 id="header">Welcome, <?php echo $_SESSION['user']?></h1>

      <div class="content">
        <div class="nav-wrapper">
          <form action="/routes/upload.php" method="post" enctype="multipart/form-data">
            <label id="filestring" for="importcsv"></label>
            <input id="file-upload" name="file" class="nav-button" type='file'/>
            <label for="file-upload" class="nav-button" id="importfile">
              <span>Import Record(s)</span>
            </label>
            <p class="error">*Wrong file type, only CSV allowed</p>
            <button type="submit" id="upload" class="nav-button" disabled>Upload</button>
          </form>
        </div>
      </div>
      <h3 id="file-prompt">Only CSV files permitted</h3>

      <?php
        if(isset($_SESSION['upload'])){
          if($_SESSION['upload'] == "failed"){
            echo "<h2 class='error file-error'>File failed to upload</h2>";
          }else if($_SESSION['upload'] == "success"){
            if($_SESSION['affected_rows'] > 0){
              echo "<h2 class='success'>File uploaded successfully</h2>";
            }else{
              echo "<h2 class='success' style='color:grey'>No new records added</h2>";
            }
          }
          unset($_SESSION['upload']);
        }
      ?>

  <script src="/js/dashboard.js"></script>
  </body>
</html>