<?php

require_once( __DIR__ . "/functions.php" );

$json = array(
    'success' => false,
    'message' => "",
);

//if there is no submitted in post
if( $_POST['filter'] == "1"){
        $json['message'] = "Invalid back folder";
        echo json_encode( $json );
        exit();
}

//insert the filter value in mysql
$html_output = back_folder( $_POST['filter'], $_POST["sortby"], $_POST["search"] );
$json['html_output'] = $html_output;
$json['success'] = true;
$json['message'] = "Success!";
echo json_encode( $json );
exit();
?>