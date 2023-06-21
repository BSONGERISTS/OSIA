<?php
$login = false;
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $mysqli = require __DIR__ . "/database.php";
    $sql = sprintf("SELECT * FROM users WHERE user = '%s'", $mysqli->real_escape_string($_POST["username"]));
    $result = $mysqli->query($sql);
    $username = $result->fetch_assoc();
    if($username){
        if ($_POST["password"] == $username["password"]){
            session_start();
            $_SESSION["id"] = $username["id"];
            header("Location: OSIA-Document.php");
            exit;
        }
    }
    $login = true;
}
?>

<html>
  <head>
    <link rel="stylesheet" href="OSIA-LogInStyle.css">
    <link rel="icon" type="image/png" href="headerpng.png">
    <title>OSIA: Organized System Information Assistant</title>
  </head>
  <body>
    <div class="container">
      
    <?php if ($login): ?>
        <em>Invalid login</em>
      <?php endif; ?>

      <div class="circle">

      <div class="element element3"></div>
      <form method="post">
        <div class="username-input">
          <input type="text" name="username" placeholder="Username" maxlength="50" required value = <?= $_POST["username"] ?? ""?>>
        </div>
        <div class="password-input">
          <input type="password" name="password" placeholder="Password" required value = <?= $_POST["password"] ?? ""?>>
          <button type="button" onclick="togglePassword()" class="show-password-button" name="submit-button"></button>
        </div>
        <button class="login-button" type="submit"><b>LOGIN</b></button>
      </form>

      </div>
      <div class="element element1"></div>
      <div class="element element2"></div>

    </div>
    
                <!--Function-->
    <script>
      function togglePassword() {
        var passwordInput = document.querySelector("input[name='password']");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
      }
      function ToDocu(){
        window.location.href = "OSIA-Document.html";
      }
    </script>
  </body>
</html>
