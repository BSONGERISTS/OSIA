<?php

function mysql ( $foldernumber = 1, $sortby = "ASC", $search =""){

    if ($sortby == "Sort by"){
        $sortby = "ASC";
    }

    //connect through mysql database
    $mysqli = require __DIR__ . "/database.php";

    //getting folders from directories in mysql
    $sql = "SELECT * FROM directories WHERE parent_id ='" . $foldernumber . "' AND folder_name LIKE '%". $search . "%' ORDER BY folder_name ". $sortby . "";
    $result = $mysqli->query( $sql );
    $folders = $result->fetch_all( MYSQLI_ASSOC );

    //getting files from osia in mysql
    $sql = "SELECT * FROM osia WHERE folder_id ='" . $foldernumber . "' AND file LIKE '%". $search . "%' ORDER BY file ". $sortby . "";
    $result = $mysqli->query( $sql );
    $files = $result->fetch_all( MYSQLI_ASSOC );

    //defining the variables to avoid errors in return
    $returning_folders= "";
    $returning_files = "";

    //getting the folders
    foreach($folders as $key => $row){
        $returning_folders .= '<input type="button" id = "'. $row["id"].'" class="files path" value="'. $row["folder_name"] .'">'; // dis is a folder
    }

    //getting the files
    foreach($files as $key => $row){
        $returning_folders .= '<input type="button" class="files" value="'. $row["file"] .'">'; // dis is a folder
    }

    return $returning_folders . $returning_files;

}

function print_a( $string ){
    
    echo "<pre>";
    print_r( $string );
    echo "</pre>";
    
}
?>