<?php 
if(isset($_SESSION)){
    header("Location: /account/dashboard.php");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="/css/register.css"/>
    <link rel="icon" type="image/png" href="/res/logo.png"/>
  </head>
  <body>
  
  <span id="header"></span>

  <div class="register-wrapper">
    <form id="registerform" action="/routes/register.php" method="post">
        <label for="username">Enter a Username:</label>
        <input name="user" id="username" type="text" />
        <label for="password">Enter a Password:</label>
        <input name="pass" id="password" type="password" />
        <label for="passwordconfirm">Confirm Password:</label>
        <input name="passconfirm" id="passwordconfirm" type="password" />
        <button id="register" type="button">Register</button>
        <p id="error">Usernames and passwords must be over 5 characters<br />
            Check password confirmation</p>
    </form>
  </div>
  <div class="register-link" >
    <a href="/routes/loginpage">Have an account? Login here!</a>
  </div>
  <script src="/js/register.js"></script>
  <?php if(isset($_GET['error'])): ?>
    <?php if($_GET['error'] == "failed"): ?>
    <script>
        document.getElementById("error").style.display = "block";
    </script>
    <?php else: ?>
    <script>
        var err = document.getElementById("error");
        err.style.display = "block";
        err.innerHTML = "Username already exists";
    </script>
    <?php endif; ?>
  <?php endif; ?>
  </body>
</html>