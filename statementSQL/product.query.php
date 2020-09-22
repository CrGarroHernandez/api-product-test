<?php

require_once './db/connection.php';
require_once './exception/alert.php';

class ProductQuery extends Connection{

    public function selectAll(){
        $query = "SELECT id, name, price FROM product;";
        return parent::getData($query);
    }

    public function select($id = 0){
        $query = "SELECT id, name, price FROM product WHERE id = $id;";
        return parent::getData($query);
    }

    public function insert($name, $price){
        $query = "INSERT INTO product(name, price) VALUES ('". $name. "' , $price);";
        return parent::statementWithId($query);
    }

    public function update($id, $name, $price){
        $query = "UPDATE product SET name= '". $name. "', price= $price WHERE id= $id;";
        return parent::statement($query);
    }

    public function delete($id){
        $query = "DELETE FROM product WHERE id= $id;";
        return parent::statement($query);
    }
}

?>