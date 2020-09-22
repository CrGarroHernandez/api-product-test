<?php

require_once './db/connection.php';
require_once './exception/alert.php';

class AuthQuery extends Connection{

    public function encryptPass($password){
        return parent::encrypt($password);
    }
    
    public function getUser($email){
        $query = "SELECT id, email, password, status FROM user WHERE email = '$email';";
        $data = parent::getData($query);
        if(isset($data[0]['id'])){
            return $data;
        }else{
            return 0;
        }
    }

    public function generateToken($user_id){
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $date = date("Y-m-d H:i:s");
        $status = 1;
        $query = "INSERT INTO `user_token`(`user_id`, `token`, `date`, `status`) VALUES ('$user_id', '$token', '$date', '$status');";
        $result = parent::statement($query);
        if($result){
            return $token;
        }else{
            return 0;
        }
    }

    public function getToken($token){
        $query = "SELECT id, user_id, token, date, status, created_at, updated_at FROM user_token WHERE token = '". $token."'AND status = 1";
        $result = parent::getData($query);
        if($result){
            return $result;
        }else{
            return 0;
        }
    }
    
    public function desactivateToken($user_id, $token){
        $query = "UPDATE user_token SET status= 0 WHERE user_id = $user_id and token <> '". $token ."';";
        return parent::statement($query);
    }

    public function updateToken($id){
        $date = date("Y-m-d H:i:s");
        $query = "UPDATE user_token SET date = $date WHERE id = $id;";
        $result = parent::statement($query);
        if($result >= 1){
            return $result;
        }else{
            return 0;
        }
    }
}