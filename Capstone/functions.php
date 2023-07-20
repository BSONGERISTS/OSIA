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
        $returning_folders .= '<div class="folder2">
        <input type="button" id = "'. $row["id"].'" class="folder path" value="'. $row["folder_name"] .'" >
        </div>'; // dis is a folder
    }

    //getting the files
    foreach($files as $key => $row){
        $returning_folders .= '<div class="files2">
        <input type="button" class="files" value="'. $row["file"] .'">
        </div>'; // dis is a file
    }

    return $returning_folders . $returning_files;

}

function back_folder($foldernumber = 1, $sortby = "ASC", $search =""){

    //connect through mysql database
    $mysqli = require __DIR__ . "/database.php";

    //getting parent_folder from directories in mysql
    $sql = "SELECT * FROM directories WHERE id ='" . $foldernumber . "'";
    $result = $mysqli->query($sql);
    $back_folder = $result->fetch_assoc();

    //setting the new parent folder
    $foldernumber = $back_folder["parent_id"];

    //fetching the information with new parent folder
    $returning = "";
    $returning = mysql ( $foldernumber, $sortby, $search);

    return $returning;
}

function delete($foldernumber = 1, $sortby = "ASC", $search ="", $delete, $directory){

    //connect through mysql database
    $mysqli = require __DIR__ . "/database.php";

    //delete is the name of the file, not the directory

    if ( strpos( $delete, ".") ){

        unlink( $directory . "/" . $delete );
        $sql = "DELETE FROM osia WHERE folder_id='". $foldernumber ."' AND file='". $delete ."';";
        $mysqli->query($sql);

    }
    else{
        // $files = scandir($directory . "/" . $delete );
        // foreach ($files as $file){
        //     if($file == '.' or $file =='..'){
        //         continue;
        //     }
        //     else{
        //         unlink( $directory . "/" . $file );
        //         $sql = "DELETE FROM osia WHERE folder_id='". $foldernumber ."' AND file='". $file ."';";
        //         $mysqli->query($sql);
        //     }
        // }
        
        // rmdir($directory . "/" . $delete);
    }

    //fetching the information with parent folder
    $returning = "";
    $returning = mysql ( $foldernumber, $sortby, $search);

    return $returning;
    

}

function print_a( $string ){
    
    echo "<pre>";
    print_r( $string );
    echo "</pre>";
    
}
?>