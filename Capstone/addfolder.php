<?php

require_once( __DIR__ . "/functions.php" );

//if someone goes to addfolder.php without adding
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    exit("Post request method required");
}

//if there is click on button submit
if( !empty( $_POST["input_foldername"] ) ){

        //adding new destinations at local folder
        $destinations = $_POST["under_folder"]. "/" . $_POST["input_foldername"];
        
        //getting the foldername and folder parent for sql
        $foldername = $_POST["input_foldername"];
        $parent_folder = $_POST ["folder_id"];
        

        if ( !file_exists( $destinations ) ) {

                //create folder at website folder
                mkdir( $destinations, 0777, true );

                //connecting the sql
                $mysqli = require __DIR__ . "/database.php";

                
                $sql = "INSERT INTO directories (folder_name, parent_id) VALUES ('" . $foldername . "', '". $parent_folder ."');";
                $mysqli->query ( $sql);
                        
        }
}

//go back to osia-document
header("Location: OSIA-Document.php");
exit;

?>