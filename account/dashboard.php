<?php 
if(!isset($_SESSION)){
    session_start();
  }

if(!isset($_SESSION['user'])){
  header("Location: ../index.php");
}

require("../constants.php");

$conn = mysqli_connect(SERVER, ADMIN, ADMINPASS, DB);
$query = "SELECT * FROM " . $_SESSION['user'] . ";";
$result = $conn->query($query);

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
        <div class="mobile-nav">
          <span id="nav-icon"></span>
        </div>
        <span id="logout-button"><i class="fa fa-sign-out"></i>   Logout</span>
      </nav>
      <h1 id="header">Welcome, <?php echo $_SESSION['user']?></h1>

      <div class="content">
        <div class="nav-wrapper">
          <form id="desktop-nav" action="/routes/upload.php" method="post" enctype="multipart/form-data">
            <label id="filestring" for="importcsv"></label>
            <input id="file-upload" name="file" class="nav-button" type='file'/>
            <label for="file-upload" class="nav-button" id="importfile">
              <span>Import Record(s)</span>
            </label>
            <p class="error">*Wrong file type, only CSV allowed</p>
            <button type="submit" id="upload" class="nav-button" disabled>Upload</button>
            <button type="button" class="nav-button add">Add Record</button>
            <button type="button" class="nav-button delete">Delete Record</button>
            <button type="button" id="deleteall" class="nav-button delete">Delete All</button>
          </form>
        </div>
        <?php if($result->num_rows > 1): ?>
      <div id="style-2" class="table-wrapper">
        <table id="maintable">
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Company</th>
            <th class="profession">Profession</th>
            <th>View</th>
          </tr>
          <?php while(($row = $result->fetch_row()) != null){?>
          <tr>
            <td><?php echo $row[1] ?></td>
            <td><?php echo $row[2] ?></td>
            <td class="profession"><?php echo $row[3] ?></td>
            <td><?php echo $row[4] ?></td>
            <td class="view-more">View more...</td>
            <td hidden class="cellId"><?php echo $row[0] ?></td>
            <?php foreach($row as $value){?>
            <td hidden class="row <?php echo $row[0] ?>"><?php echo $value ?></td>
            <?php } ?>
          </tr>
          <?php } ?>
        </table>
      </div>
      <?php else: ?>
      <h1>No data yet... Insert data</h1>
      <?php endif; ?>
      </div>
      <h3 id="file-prompt">Only CSV files permitted</h3>

      <?php
        if(isset($_GET['delete'])){
          if($_GET['delete'] == "all"){
            echo "<h2 class='success' style='color:grey'>All records successfully deleted</h2>";
          }
        }
      ?>

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

  <div class="prompt" id="logout-prompt">
    <p>Are you sure you want to logout?</p>
    <button id="logout-yes">Yes</button>
    <button id="logout-no">No</button>  
  </div>
  <div class="prompt" id="deleteall-prompt">
    <p>Are you sure you want to delete all records?</p>
    <button id="deleteall-yes">Yes</button>
    <button id="deleteall-no">No</button>  
  </div>

  <div class="loader-wrapper">
    <img id="loader" src="/res/loader.gif" />
  </div>

  <script src="/js/dashboard.js"></script>
  </body>
</html>