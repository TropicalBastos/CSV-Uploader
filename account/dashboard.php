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
        <span class="logo"></span>
        <span id="help-button">Help</span>
        <span id="logout-button"><i class="fa fa-sign-out"></i>   Logout</span>
      </nav>
      <div class="delete-error-wrapper">
        <h2 class="error delete-error">No records selected</h2>
      </div>

      <h1 class="dashboard header">Welcome, <?php echo $_SESSION['user']?></h1>

      <div class="full-nav">
        <span class="close"></span>
        <ul>
          <li id="choose-upload" class="nav-item"><label id="nav-upload" for="file-upload">Choose File...</label>
          <li id="mobile-upload" class="nav-item disabled"><span>Upload</span>
          <li id="mobile-add" class="nav-item"><span>Add Record</span>
          <li id="mobile-delete" class="nav-item"><span>Delete Record</span>
          <li id="mobile-all" class="nav-item"><span>Delete All</span>
          <li id="mobile-help" class="nav-item"><span>Help</span>
          <li id="mobile-logout" class="nav-item"><span>Logout</span>
        </ul>
      </div>

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
        <?php if($result->num_rows >= 1): ?>
      <div id="style-2" class="table-wrapper">
        <table id="maintable">
          <tr>
            <th>Select</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>View</th>
          </tr>
          <?php while(($row = $result->fetch_row()) != null){?>
          <tr>
            <td><input type="checkbox"/></td>
            <td><?php echo $row[1] ?></td>
            <td><?php echo $row[2] ?></td>
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
        if(isset($_SESSION['delete'])){
          if($_SESSION['delete'] == "all"){
            echo "<h2 class='success' style='color:grey'>All records successfully deleted</h2>";
            unset($_SESSION['delete']);
          }
        }
      ?>

      <?php
        if(isset($_SESSION['add_error'])){
          echo "<h2 class='error file-error' >Error while adding record</h2>";
          unset($_SESSION['add_error']);
        }
      ?>
      
      <?php
        if(isset($_SESSION['added'])){
            echo "<h2 class='success'>Record successfully added</h2>";
            unset($_SESSION['added']);
        }
      ?>

      <?php
        if(isset($_SESSION['deleted'])){
            echo "<h2 class='success'>Record successfully deleted</h2>";
            unset($_SESSION['deleted']);
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
  <div class="prompt" id="delete-prompt">
    <p>Are you sure you want to delete the selected record(s)?</p>
    <button id="delete-yes">Yes</button>
    <button id="delete-no">No</button>  
  </div>
  <div class="prompt" id="deleteall-prompt">
    <p>Are you sure you want to delete all records?</p>
    <button id="deleteall-yes">Yes</button>
    <button id="deleteall-no">No</button>  
  </div>

  <div class="add-modal-wrapper">
  <div class="add-modal">
    <form method="post" id="add-form" action="/account/add.php" id="add-form">
    <div class="page 1 active">
      <label for="add-first">*First Name:</label>
      <input type="text" name="first" id="add-first"/>
      <label for="add-last">*Last Name:</label>
      <input type="text" name="last" id="add-last"/>
      <label for="add-company">Company Name:</label>
      <input type="text" name="company" id="add-company"/>
      <label for="add-profession">Profession:</label>
      <input type="text" name="profession" id="add-profession"/>
      <label for="add-chapter">Chapter Name:</label>
      <input type="text" name="chapter" id="add-chapter"/>
      <button class="next" type="button">Next</button>
      <button class="cancel" type="button">Cancel</button>
    </div>
    <div class="page 2">
      <label for="add-phone">Phone Number:</label>
      <input type="text" name="phone" id="add-phone"/>
      <label for="add-altphone">Alternate Phone:</label>
      <input type="text" name="altphone" id="add-altphone"/>
      <label for="add-cell">Mobile:</label>
      <input type="text" name="cell" id="add-cell"/>
      <label for="add-fax">Fax:</label>
      <input name="fax" id="add-fax" type="text"/>
      <label for="add-email">*Email:</label>
      <input type="text" name="email" id="add-email"/>
      <button type="button" class="back">Back</button>
      <button class="next" type="button">Next</button>
      <button class="cancel" type="button">Cancel</button>
    </div>
    <div class="page 3">
      <label for="add-website">Website:</label>
      <input type="text" name="website" id="add-website"/>
      <label for="add-address">Address:</label>
      <input type="text" name="address" id="add-address"/>
      <label for="add-city">City:</label>
      <input name="city" id="add-city" type="text"/>
      <label for="add-state">State:</label>
      <input name="state" id="add-state" type="text"/>
      <label for="add-zip">Zip:</label>
      <input name="zip" id="add-zip" type="text"/>
      <button class="back" type="button">Back</button>
      <button class="next" type="button">Next</button>
      <button class="cancel" type="button">Cancel</button>
    </div>
    <div class="page 4">
      <label for="add-sub">Substitute:</label>
      <input name="substitute" id="add-sub" type="text"/>
      <label for="add-status">Status:</label>
      <input name="status" id="add-status" type="text"/>
      <label for="add-join">Join Date (MM/DD/YYYY):</label>
      <input name="join" id="add-join" type="text"/>
      <label for="add-sponsor">Sponsor:</label>
      <input name="sponsor" id="add-sponsor" type="text"/>
      <button type="button" class="back">Back</button>
      <button id="form-submit" type="button">Submit</button>
      <button type="button" class="cancel">Cancel</button>
      <p class="error add-error">First/Last Name's and Email fields required</p>
    </div>
    </form>
    </div>
  </div>

  <div class="loader-wrapper">
    <img id="loader" src="/res/loader.gif" />
  </div>

  <div class="help-prompt">
    <h2>Help</h2>
    <span class="close-help"></span>
    <p>Peoplify is a mini database web app capable of taking in csv files and storing data about people
      remotely</p>
    <p>To store data via file import, you have to select a csv file with the following columns 
      (of course many unrelevant fields can be left blank). Data will be appended to your account's dashboard table</p>
    <ul>
      <li>First Name</li>
      <li>Last Name</li>
      <li>Company</li>
      <li>Profession</li>
      <li>Chapter Name</li>
      <li>Phone Number</li>
      <li>Alternate Phone</li>
      <li>Fax Number</li>
      <li>Mobile Phone</li>
      <li>Email</li>
      <li>Website</li>
      <li>Address</li>
      <li>City</li>
      <li>State</li>
      <li>Zip</li>
      <li>Substitute</li>
      <li>Status</li>
      <li>Join Date</li>
      <li>Renewal</li>
      <li>Sponsor</li>
    </ul>
    <p>Records can be added manually through the add record in which you can fill out a form corresponding to the values
      that will be stored</p>
    <p>Records can be deleted via selecting the appropiate record's checkbox or if you truly wish you can delete 
      every record stored through the delete all option</p>
  </div>

  <script src="/js/dashboard.js"></script>
  </body>
</html>