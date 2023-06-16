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
                <div class="proftext"><b class="font">Profile</b></div>
                <input class="name" style="font-weight: bold" disabled value= <?= $username["name"] ?>>
                <input class="username" style="font-weight: bold" value= <?= $username["user"] ?>>
                <input class="Birth" style="font-weight: bold" value= <?= $username["dob"] ?>>
                <input class="pass" style="font-weight: bold" value= <?= $username["password"] ?>>
                <input class="contact" style="font-weight: bold" value= <?= $username["contact"] ?>>
                <input class="Email" style="font-weight: bold" value= <?= $username["email"] ?>>
                <div class="leftname"><b class="font">Name</b></div>
                <div class="leftusername"><b class="font">Username</b></div>
                <div class="leftbirth"><b class="font">Date of Birth</b></div>
                <div class="leftpass"><b class="font">Password</b></div>
                <div class="leftcontact"><b class="font">Contact</b></div>
                <div class="leftemail"><b class="font">Email Address</b></div>
            </div>

            <div id="popcontent" class="hidden">
                <div class="mescon2"></div>
                <div class="messagecon"><b class="font">Messages</b></div>
            </div>
            <button class="message" id="ms" onclick="Popout()"><b class="font">Message</b></button>
            <form action="logout.php">
                <button class="Logout"><b class="font">Logout</b></button>
            </form>
        </div>
    </body>
                    <!--Function-->
    <script>
        function Popout() {
        var popcontent = document.getElementById("popcontent");
        popcontent.classList.toggle("hidden");
        popcontent.classList.toggle("visible");
        }
    </script>
</html>
