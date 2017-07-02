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
    <title>Member Login</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
  </head>
  <body>
  
  <span id="header"></span>

  <div class="login-wrapper">
    <form action="routes/login.php" method="post">
        <label for="username">Username:</label>
        <input name="user" id="username" type="text" />
        <label for="password">Password:</label>
        <input name="pass" id="password" type="password" />
        <button id="login">Login</button>
    </form>
    <?php 
      if(isset($_SESSION['loginfailed'])){
        echo "<h3 id='user-error'>*Error wrong username or password<h3>";
      }
     ?>
  </div>

  </body>
</html>