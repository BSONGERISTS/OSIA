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
    <div class="scontainer"></div>
    <div class="container">
      <div class="logtext">LOGIN</div>
      <form method="post">
        <div class="username-input">
          <img src="solar_user-bold.svg" height="30px" width="30px" draggable="false">
          <input type="text" name="username" placeholder="Username" maxlength="50" required value = <?= $_POST["username"] ?? ""?>>
        </div>
        <div class="password-input">
          <img src="Vector.svg" height="25px" width="25px" draggable="false">
          <input type="password" name="password" placeholder="Password" required value = <?= $_POST["password"] ?? ""?>>

          <button type= "button" onclick="togglePassword()" class="show-password-button" name="submit-button">
            <img src="Eye.svg" height="25px" width="25px" draggable="false">
          </button>
            <?php if ($login): ?>
            <b id="invalid">Incorrect Username or Password</b>
            <?php endif; ?>
        </div>
        <button class="login-button" type="submit"><b>LOGIN</b></button>
      </form>
    </div>

    <div class="element1">
      <img src="OSIALogo.svg" height="170px" width="170px" draggable="false">
    </div>
    <div class="element2">
      <img src="IQAOlogo.svg" height="100px" width="100px" draggable="false">
    </div>
    <div class="element3">
      <img src="image 13.svg" height="100px" width="100px" draggable="false">
    </div>
    <div class="element4">
      <img src="image 15.svg" height="150px" width="150px" draggable="false">
    </div>
    <div class="httptext">https://dlsl.edu.ph | Trunkline: (+63 043) 302 2900</div>
    <a href="OSIA-AboutUs.php" class="aboutus">About Us</a>
    <div class="Bigtext"><b>Organize to Success.</b></div>
    <div class="Avtext"><b>A FILE ORGANIZING TOOL DESIGNED FOR THE INSTITUTIONAL QUALITY ASSURANCE OFFICE OF DE LA SALLE LIPA.</b></div>


                <!--Function-->
    <script>
      function togglePassword() {
        var passwordInput = document.querySelector("input[name='password']");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
      }
      function ToDocu(){
        window.location.href = "OSIA-Document.php";
      }
    </script>
  </body>
</html>
