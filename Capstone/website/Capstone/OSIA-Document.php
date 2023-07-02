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
        <link rel="stylesheet" href="OSIA-DocumentStyle.css">
        <link rel="icon" type="image/png" href="headerpng.png">
        <title>OSIA: Organized System Information Assistant</title>
    </head>
    <body>
        <div class="container">
            <form action="OSIA-Profile.php">
                <button class="profile"></button>
            </form>
            <div class="elem1"></div>
            <button class="message" id="ms" onclick="Popout()"><b class="font">Message</b></button>
            <div class="preview"></div>
            <div class="documentprev"><b class="font">Document Preview</b></div>
            <button class="delete"></button>
            <button class="print"></button>
            <button class="download"></button>
            <button class="Zoomin"></button>
            <button class="Zoomout"></button>
            <div class="search">
                <input type="text" placeholder="Search for a Document">
            </div>
            <button class="find"></button>
            <div class="Folders"></div>
            <div class="foldertab"></div>
            <button class="Previous"></button>
            <button class="Next"></button>
            <button class="add"></button>
            <button class="tap"></button>
            <select placeholder="Sort by">
                <option disabled selected>Sort by</option>
                <option value="option1">A-Z</option>
                <option value="option2">Z-A</option>
                <option value="option3">Date</option>
            </select>
            <div id="popcontent" class="hidden">
                <div class="mescon2"></div>
                <div class="messagecon"><b class="font">Messages</b></div>
            </div>
            <form action="logout.php">
                <button class="Logout"><b class="font">Logout</b></button>
            </form>
        </div>
                    <!--Function-->
            <script>
                function Popout() {
                var popcontent = document.getElementById("popcontent");
                popcontent.classList.toggle("hidden");
                popcontent.classList.toggle("visible");
                }
            </script>
    </body>
</html>