<?php

class Connection{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connection;

    function __construct(){
        $this->connect();
    }

    private function getParam(){
        $file = dirname(__FILE__);
        $jsonParam = file_get_contents($file . "/". "param.txt");
        return json_decode($jsonParam, true);
    }

    private function connect(){
        $param = $this->getParam();
        foreach($param as $key => $value){
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->connection = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);

        if($this->connection -> connect_errno){
            return "Error de Conexión (". $this->connection -> connect_error. ")";
        }
    }

    private function utf8($array){
        array_walk_recursive($array, function($item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    public function getData($sqlStr){
        $result = $this->connection->query($sqlStr);
        $resultArray = array();
            foreach($result as $key){
                $resultArray[] = $key;
            }
        return $this->utf8($resultArray);
        //return json_encode($resultArray);
    }

    public function statement($sqlStr){
        $result = $this->connection->query($sqlStr);
        $rows = $this->connection->affected_rows;     
        return $rows;   
    }

    public function statementWithId($sqlStr){
        $result = $this->connection->query($sqlStr);
        $rows = $this->connection->affected_rows;
        //if($rows > 0){
            return $this->connection->insert_id;
        //}else{
            //return 0;
       // }        
    }

    protected function encrypt($string){
        return md5($string);
    }
}
?>