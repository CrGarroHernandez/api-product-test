<?php
require_once './classes/auth.class.php';
require_once './exception/alert.php';

$auth = new Auth;
$alert = new Alert;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: POST');


    $form = file_get_contents("php://input");
    $resp = $auth->login($form);
    echo json_encode($resp);
    http_response_code(200);
    
}else{
    header('Content-Type: application/json');
    echo json_encode($alert->clientError_405());
}
?>