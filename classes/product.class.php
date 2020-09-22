<?php
require_once './statementSQL/product.query.php';
require_once './statementSQL/auth.query.php';
require_once './exception/alert.php';


class Product{

    private $productQuery;
    private $authQuery;
    private $alert;

    private $id;
    private $name;
    private $price;

    private $token;

    function __construct() {
        $this->productQuery = new ProductQuery();
        $this->authQuery = new AuthQuery();
        $this->alert = new Alert();

        $this->id = 0;
        $this->name = "";
        $this->price = 0;

        $this->token = "";
    }

    function create($form){
        $dataForm = json_decode($form, true);

        if(!isset($dataForm['token'])){
            return $this->alert->clientError_401();
        }
        else{
            $this->token = $dataForm['token'];
            if($this->authQuery->getToken($this->token)){
                if(isset($dataForm['name'])){
                    $this->name = $dataForm['name'];
                    if(isset($dataForm['price']) && $dataForm['price']>0){$this->price = $dataForm['price'];}
        
                    $result = $this->productQuery->insert($this->name, $this->price);
        
                    if($result){
                        return $this->alert->customSuccess("Product registered successfully");
                    }else{
                        return $this->alert->serverError_500();
                    }   
                    
                }else{
                    return $this->alert->clientError_400();
                }
            }else{
                return $this->alert->clientError_401();
            }
        }

    }

    function read($id = 0){
        if($id > 0){
            return $this->productQuery->select($id);
        }else{
            return $this->productQuery->selectAll();
        }
        
    }

    function update($form){
        $dataForm = json_decode($form, true);

        if(isset($dataForm['id']) && isset($dataForm['name'])){

            $this->id = $dataForm['id'];
            $this->name = $dataForm['name'];
            if(isset($dataForm['price']) && $dataForm['price']>0){$this->price = $dataForm['price'];}

            $result = $this->productQuery->update($this->id, $this->name, $this->price);

            if($result){
                return $this->alert->customSuccess("Product updated successfully");
            }else{
                return $this->alert->serverError_500();
            }   
            
        }else{
            return $this->alert->clientError_400();
        }
    }

    function delete($form){
        $dataForm = json_decode($form, true);

        if(isset($dataForm['id'])){
            $this->id = $dataForm['id'];

            $result = $this->productQuery->delete($this->id);

            if($result){
                return $this->alert->customSuccess("Product removed successfully");
            }else{
                return $this->alert->serverError_500();
            }   
            
        }else{
            return $this->alert->clientError_400();
        }
    }
}

?>