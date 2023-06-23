<?php
session_start();
if(isset($_SESSION["id"])){
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM users WHERE id = {$_SESSION["id"]}";
    $result = $mysqli->query($sql);
    $username = $result->fetch_assoc();
}
else{
    header("Location: OSIA-LogIn.php");
    exit;
}
$edit = false;
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $sql = "UPDATE `users` SET `name` = '{$_POST["name"]}', `dob` = '{$_POST["dob"]}', `contact` = '{$_POST["contact"]}' WHERE `users`.`id` = {$_SESSION["id"]}";
    $result = $mysqli->query($sql);
    $edit = true;
}
?>

<html>
    <head>
        <link rel="stylesheet" href="OSIA-ProfileStyle.css">
        <link rel="icon" type="image/png" href="headerpng.png">
        <title>OSIA: Organized System Information Assistant</title>
    </head>
    <body>
        <div class="container">
            <div class="logcontainer">
                <div class="circle"></div>
                <button class="scircle"></button>
                <div class="proftext"><b class="font"></b></div>
                <div class="leftname"><b class="font">Name</b></div>
                <div class="leftusername"><b class="font">Username</b></div>
                <div class="leftbirth"><b class="font">Date of Birth</b></div>
                <div class="leftpass"><b class="font">Password</b></div>
                <div class="leftcontact"><b class="font">Contact</b></div>
                <div class="leftemail"><b class="font">Email Address</b></div>
                <form method="post">
                    <input name="name" class="name" style="font-weight: bold" value= "<?= $_POST["name"] ?? $username["name"] ?>">
                    <input class="username" style="font-weight: bold" value= "<?= $username["user"] ?>" disabled>
                    <input class="pass" type="password" style="font-weight: bold" value= "<?= $username["password"] ?>" disabled>
                    <input name="dob" type="date" class="Birth" style="font-weight: bold" value= "<?= $_POST["dob"] ?? $username["dob"] ?>" >
                    <input name="contact" class="contact" style="font-weight: bold" value= "<?= $_POST["contact"] ?? $username["contact"] ?>">
                    <input class="Email" style="font-weight: bold" value= "<?= $username["email"] ?>">
                    <button class="edit"></button>
                </form>
                <?php if ($edit): ?>
                    <b id="update">Your profile updated successfuly</b>
                <?php endif; ?>
                <div class="lockA"></div>
                <div class="lockB"></div>
                <div class="lockC"></div>
            </div>
            <div id="popcontent" class="hidden">
                <div class="mescon2"></div>
                <div class="messagecon"><b class="font">Messages</b></div>
            </div>
            <button class="message" id="ms" onclick="Back()"><b class="font">Back</b></button>
            <form action="logout.php">
                <button class="Logout"><b class="font">Logout</b></button>
            </form>
        </div>
    </body>
                    <!--Function-->
    <script>
        function Back() {
            window.location.href = "OSIA-Document.php";
        }
    </script>
</html>
