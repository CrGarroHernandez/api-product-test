<?php
require_once 'classes/product.class.php';
require_once 'exception/alert.php';

$product = new Product;
$alert = new Alert;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    header("Content-Type: application/json");
    $form = file_get_contents("php://input");
    $resp = $product->create($form);
    echo json_encode($resp);
    http_response_code(200);

}else if($_SERVER['REQUEST_METHOD'] === 'GET'){
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        header("Content-Type: application/json");
        echo json_encode($product->read($id));
        http_response_code(200);
    }else{
        header("Content-Type: application/json");
        echo json_encode($product->read());
        http_response_code(200);
    }

}else if($_SERVER['REQUEST_METHOD'] === 'PUT'){

    header("Content-Type: application/json");
    $form = file_get_contents("php://input");
    $resp = $product->update($form);
    echo json_encode($resp);
    http_response_code(200);

}else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    header("Content-Type: application/json");
    $form = file_get_contents("php://input");
    $resp = $product->delete($form);
    echo json_encode($resp);
    http_response_code(200);

}else{
    header('Content-Type: application/json');
    echo json_encode($alert->clientError_405());
}


?>