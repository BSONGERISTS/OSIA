<?php

require_once( __DIR__ . "/functions.php" );

$json = array(
    'success' => false,
    'message' => "",
);

//if there is no submitted in post
if( $_POST['delete'] =="Please select a folder or file" ){
        $json['message'] = "Please select a folder or file";
        echo json_encode( $json );
        exit();
}

//insert the filter value in mysql
$html_output = delete( $_POST['filter'], $_POST["sortby"], $_POST["search"], $_POST["delete"], $_POST["directory"]);
$json['html_output'] = $html_output;
$json['success'] = true;
$json['message'] = "Success!";
echo json_encode( $json );
exit();
?>