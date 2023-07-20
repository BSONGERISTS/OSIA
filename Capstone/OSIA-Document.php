<?php

require_once( __DIR__ . "/functions.php" );

//if logged in
session_start();
if(isset($_SESSION["id"])){
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM users WHERE id = '". $_SESSION["id"] ."'";
    $result = $mysqli->query($sql);
    $username = $result->fetch_assoc();
}
//if not logged in
else{
    header("Location: OSIA-LogIn.php");
    exit;
}


?>

<html>
    <head>
        <link rel="stylesheet" href="OSIA-DocumentStyle.css">
        <link rel="icon" type="image/png" href="headerpng.png">
        <script src="jquery-3.6.4.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        <script>

        $(document).ready(function ( $ ) {

                //if buttons are clicked in the div.folders
                $(document).on("click", "input.files, input.path", function(){

                    //if button is a folder
                    if ($( "input.selected" ).val() == $( this ).val() && $(this). hasClass("path")){

                        //getting the id of folder
                        $( 'input.parent_folder' ).val( $(this).attr("id") );
                        
                        //getting the directory name in the pc uploads/....
                        $('input.hidden_dir').val( $('input.hidden_dir').val() + "/" + $(this).val());

                        //clearing the selection for delete
                        $( "input.selected" ).val("Please select a folder or file");

                        //creating ajax
                        $.ajax({
                            dataType: "JSON",
                            type:"POST",
                            url: "ajax.php",
                            data: {
                                filter: $( this ).attr("id"), sortby: $("select.sort").find(":selected").val(), search: $("input.search_input").val()
                            },
                            success: function ( data ){
                                if( data.success === false ){
                                    alert( data.message );
                                }
                                else{
                                    $( "div.items" ).html( data.html_output );
                                }
                            }

                        });

                    }

                    //if the button is a file
                    else if($(this). hasClass("files")){
                        $( "input.selected" ).val( $( this ).val() );
                        $( "iframe.filepreview" ).attr( "src", $('input.hidden_dir').val() + "/" + $( this ).val() );
                    }

                    else{
                        //there will be a selected folder
                        $( "input.selected" ).val( $( this ).val() );
                    }

                });

                //if there is click on search
                $(document).on("click", "button.find", function(){
                    $.ajax({
                        dataType: "JSON",
                        type:"POST",
                        url: "ajax.php",
                        data: {
                            filter: $("input.parent_folder").val(), sortby: $( this ).val(), search: $("input.search_input").val()
                        },
                        success: function ( data ){
                            if( data.success === false ){
                                alert( data.message );
                            }
                            else{
                                $( "div.items" ).html( data.html_output );
                            }
                        }

                    });

                });

                //if previous button is clicked
                $(document).on("click", "button.previous", function(){
                    $.ajax({
                        dataType: "JSON",
                        type:"POST",
                        url: "previous.php",
                        data: {
                            filter: $("input.parent_folder").val(), sortby: $("select.sort").find(":selected").val(), search: $("input.search_input").val()
                        },
                        success: function ( data ){
                            if( data.success === false ){
                                alert( data.message );
                            }
                            else{
                                $( "div.items" ).html( data.html_output );
                            }
                        }

                    });
                    $( "input.selected" ).val("Please select a folder or file");
                    $('input.hidden_dir').val( $('input.hidden_dir').val() + "/..");
                    
                });

                //if delete button is clicked
                $(document).on("click", "button.delete", function(){
                    $.ajax({
                        dataType: "JSON",
                        type:"POST",
                        url: "delete.php",
                        data: {
                            filter: $("input.parent_folder").val(), sortby: $("select.sort").find(":selected").val(), search: $("input.search_input").val(), delete: $("input.selected").val(), directory: $('input.hidden_dir').val()
                        },
                        success: function ( data ){
                            if( data.success === false ){
                                alert( data.message );
                            }
                            else{
                                $( "iframe.filepreview" ).attr( "src", "");
                                $( "div.items" ).html( data.html_output );
                            }
                        }

                    });
                });


                //if there is input on file upload
                $(document).on("change", "input#file_input", function(){
                    $("button.submit_file").prop("disabled", false);
                });



                //if sort is changed
                $(document).on("change", "select.sort", function(){
                    $.ajax({
                        dataType: "JSON",
                        type:"POST",
                        url: "ajax.php",
                        data: {
                            filter: $("input.parent_folder").val(), sortby: $( this ).val(), search: $("input.search_input").val()
                        },
                        success: function ( data ){
                            if( data.success === false ){
                                alert( data.message );
                            }
                            else{
                                $( "div.items" ).html( data.html_output );
                            }
                        }

                    });

                });

        });

        </script>

        <title>OSIA: Organized System Information Assistant</title>
        
    </head>
    
    <body>
        
        <form action="OSIA-Profile.php">
            <button class="profile">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                <img class="profileimg" src="profileimg/<?=$username["profile"]?>">
            </button>
        </form>

        <div class="element2">
                <img src="Group 5.svg"  height="100px" width="250px" draggable="false">
                <div class="profname"><?= $username["user"] ?></div>
        </div>

        <div class="preview">
            <iframe class="filepreview" src="" frameborder="0" height="100%" width="100%"></iframe>
        </div>

        <div class="search">
            <input type="text" class="search_input" placeholder="Search for a Document">
            <button class="find">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
            </button>
        </div>

        <!--Files and Folders-->
        <div class="Folders">
            <input class="selected" value="Please select a folder or file" hidden>
            
            <div class="foldertab">
                    <button class="previous">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <path d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"/></svg>
                    </button>

                    <!-- if delete is clicked -->
                    <button class="delete">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                    </button>

                    <!--if add folder is clicked-->
                    <button class="add" onclick="addfolder()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <path d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H192c20.1 0 39.1 9.5 51.2 25.6l19.2 25.6c6 8.1 15.5 12.8 25.6 12.8H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z"/></svg>
                    </button>

                    <!--if upload button is clicked-->
                    <form id="fileupload" enctype="multipart/form-data" method="post" action="fileupload.php">
                        <input type="text" id="hidden_directory" class="hidden_dir" name="hidden_dir" value="uploads" hidden>
                        <input type="text" class="parent_folder" name="folder_id" value="1" hidden>
                        <button type="button" class="tap">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                            <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z"/></svg>
                            <input type="file" name="file_input" id="file_input" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/msword, application/pdf" class="invisible" required>
                        </button>
                        <button type="Submit" class="submit_file" disabled>Submit</button>
                    </form>

                    <!-- This is the sort option -->
                    <select placeholder="Sort by" class="sort" font=myfont>
                        <option disabled selected>Sort by</option>
                        <option value="ASC">A-Z</option>
                        <option value="DESC">Z-A</option>
                    </select>

            </div>

            <div class="items">
                <?php
                    echo mysql();
                ?>
            </div>

        </div>

        
        <!--shows the addfolder-->
        <div id="newfolder" class="hidden">
            <div class="foldermessage">
                <div class="addfoldertab">
                    <button class="close" onclick="addfolder()">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                    <path d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"/></svg>
                    </button>
                    <b class="addfoldertext">Add new Folder</b>
                    

                    <!--input folder name-->
                    <form method="post" enctype="multipart/form-data" action="addfolder.php">
                        <input name= "under_folder"class="hidden_dir" value="uploads" hidden></label>
                        <input type="text" class="parent_folder" name="folder_id" value="1" hidden>
                        <input type="text" class="flput" name="input_foldername" required>
                        <button class="buttsub">Submit</button>
                    </form>


                </div>
            </div>
        </div>
        
        <!-- Messaging -->
        <!-- <button class="message" id="ms" onclick="Popout()">
            <img src="Group 98.svg" draggable="false">
        </button> -->

        <div class="element1" height="1px" width="1px" draggable="false">
            <img src="Group 57.svg" draggable="false">
        </div>

        <div class="element3">
            <img src="image 13.svg" height="80px" width="80px" draggable="false">
        </div>

        <div class="element4">
            <img src="IQAOlogo.svg" height="80px" width="80px" draggable="false">
        </div>
        
        <!-- <div id="popcontent" class="hidden">
            <div class="mescon2">
                <div class="messagecon">
                    <button class="close" id="ms" onclick="Popout()">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                    <path d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"/></svg>
                    </button>
                    <b>Messages</b>

                </div>
            </div>
        </div> -->

        <form action="logout.php">
            <button class="Logout">Logout</button>
        </form>
        
                    <!--Function-->
            <script>
                function Popout() {
                var popcontent = document.getElementById("popcontent");
                popcontent.classList.toggle("hidden");
                popcontent.classList.toggle("visible");
                }
                function addfolder() {
                var popcontent = document.getElementById("newfolder");
                popcontent.classList.toggle("hidden");
                popcontent.classList.toggle("visible");
                }
                
            </script>
    </body>
</html>