<?php

function print_a( $string ){
    
    echo "<pre>";
    print_r( $string );
    echo "</pre>";
    
}
if ( !empty( $_POST ) ){

    $id = $_POST["idnumber"];

    // renaming the file
    $pathinfo = pathinfo($_FILES["file_input"]["name"]);
    $base = $id;
    $filename = $base . "." . $pathinfo["extension"];
    $directory = "profileimg/". $filename;

    //if there are errors on uploading
    if($_FILES["file_input"]["error"] !== UPLOAD_ERR_OK){
        switch ($_FILES["file_input"]["error"]){
            case UPLOAD_ERR_PARTIAL:
                exit("File only partially uploaded");
                break;
            case UPLOAD_ERR_EXTENSION:
                exit("File uploaded stop by a PHP extension");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                exit("Temporary folder not found");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                exit("Failed to write file");
                break;
            default:
                exit("Unknown upload error");
                break;
        }
    }

    move_uploaded_file($_FILES["file_input"]["tmp_name"], $directory);

    $mysqli = require __DIR__ . "/database.php";
    $sql = "UPDATE `users` SET `profile` = '". $filename ."' WHERE `users`.`id` = ". $id .";";
    $mysqli->query($sql);
}

//go back to osia-document
header("Location: OSIA-Profile.php");
exit;

?>