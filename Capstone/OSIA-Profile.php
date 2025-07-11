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
            <div class="logcontainer">
                <div class="circle">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                </div>
                <img class="circle" src="profileimg/<?=$username["profile"]?>">
                <button class="scircle" id="ms" onclick="Upload()">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 450">
                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg>
                </button>

                <div class="proftext"><b class="font">Profile</b></div>
                <div class="leftname"><b class="font">Name</b></div>
                <div class="leftusername"><b class="font">Username</b></div>
                <div class="leftbirth"><b class="font">Date of Birth</b></div>
                <div class="leftpass"><b class="font">Password</b></div>
                <div class="leftcontact"><b class="font">Contact</b></div>
                <div class="leftemail"><b class="font">Email Address</b></div>

                <!-- If submitted an updated profile -->
                <form method="post">
                    <input name="name" class="name" style="font-weight: bold" value= "<?= $_POST["name"] ?? $username["name"] ?>">
                    <input class="username" style="font-weight: bold" value= "<?= $username["user"] ?>" disabled>
                    <input class="pass" type="password" style="font-weight: bold" value= "<?= $username["password"] ?>" disabled>
                    <input name="dob" type="date" class="Birth" style="font-weight: bold" value= "<?= $_POST["dob"] ?? $username["dob"] ?>" >
                    <input name="contact" class="contact" style="font-weight: bold" value= "<?= $_POST["contact"] ?? $username["contact"] ?>">
                    <input class="Email" style="font-weight: bold" value= "<?= $username["email"] ?>">
                    <button class="edit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </button>
                </form>

                <!-- Outputs if profile updated -->
                <?php if ($edit): ?>
                    <b id="update">Your profile updated successfuly</b>
                <?php endif; ?>

                <!-- Uneditable areas -->
                <div class="lockA">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                </div>
                <div class="lockB">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                </div>
                <div class="lockC">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                </div>

            </div>

            <!-- image uploading for profile -->
            <div id="popcontent" class="hidden">
                <div class="mescon2">
                    <div class="uplcontainer">
                        <div class="ProfileupPrev">
                            <img id="profilepreview" class="imgpreview" src="typcn_upload.svg" draggable="false">
                    </div>
                </div>
                <div class="messagecon"><b class="font">Upload New Profile Picture</b></div>
                    <button class="cancel" onclick="Upload()"><b class="font">Cancel</b></button>

                    <!-- Preview and submit form -->
                    <form method="post" enctype="multipart/form-data" action="profileupload.php">
                        <input type="text" value="<?=$username["id"]?>" name="idnumber" hidden>
                        <button type="button" class="button1"><b class="font">Upload a Picture</b>
                            <input type="file" name="file_input" id="file_input" accept="image/png, image/jpeg" class="invisible" onchange="imagePreview(this)" required>
                        </button>
                        <button type ="Submit" class="save"><b class="font">Save</b></button>
                    </form>

                </div>
            </div>


            <button class="message" id="ms" onclick="Back()">
                <img src="Group 56.svg" draggable="false">
            </button>

            <div class="element1">
                <img src="Group 55.svg" draggable="false">
            </div>
            <div class="element2">
                <img src="image 13.svg" draggable="false">
            </div>
            <div class="element3">
                <img src="Group 2 10.svg" draggable="false">
            </div>
    </body>
                    <!--Function-->
    <script>
        function Upload() {
                var popcontent = document.getElementById("popcontent");
                popcontent.classList.toggle("hidden");
                popcontent.classList.toggle("visible");
                }
        function Back() {
            window.location.href = "OSIA-Document.php";
        }
        function imagePreview(){
            var preview = document.getElementById("profilepreview");
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.onload = function(){
                URL.revokeObjectURL(preview.src)
            }
        };
    </script>
</html>