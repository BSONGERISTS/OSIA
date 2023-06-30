<?php

function print_a( $string ){
    
    echo "<pre>";
    print_r( $string );
    echo "</pre>";
    
}

//if someone goes to upload.php without uploading
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    exit("Post request method required");
}





if( !empty( $_POST ) ){

    $filename = $_FILES["file"]["name"];
    $directory = $_POST["hidden_directory"];
    echo $directory;

    //if there are errors on uploading
    if($_FILES["file"]["error"] !== UPLOAD_ERR_OK){
        switch ($_FILES["file"]["error"]){
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

    //gets file type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($_FILES["file"]["tmp_name"]);
    $mime_types = ["application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/msword", "application/pdf"];

    //if invalid file type
    if(!in_array($_FILES["file"]["type"], $mime_types)){
        exit("Invalid file type");
    }

    //renaming file name
    $pathinfo = pathinfo($_FILES["file"]["name"]);
    $base = $pathinfo["filename"];
    $base = preg_replace("/[^\w-]/", "_", $base);
    $filename = $base . "." . $pathinfo["extension"];
    $destination = $directory . "/" .$filename;

    //renaming same file name
    $i = 1;
    while (file_exists($destination)){
    $filename = $base . "($i)." . $pathinfo["extension"];
    $destination = $directory . "/" . $filename;
    $i++;
    }
    //if can't upload file in the destination
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $destination)){
        exit("Can't move uploaded file");
    }
    
    $sql = "INSERT INTO `osia` (`directory`, `file`) VALUES ('". $directory ."', '". $filename ."');";
    $directory = $directory . $filename;
    
    echo '<br>';
    echo $directory;
    echo '<br>';
    echo $filename;

    //insert files to folder and mysql
    move_uploaded_file($_FILES["file"]["tmp_name"], $directory);
    $mysqli = require __DIR__ . "/database.php";
    $mysqli->query($sql);
    print_a( $_FILES );

    exit();
    
}

//go back to osia-document
header("Location: OSIA-Document.php");
exit;
?>
