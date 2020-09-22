<?php
require_once './statementSQL/auth.query.php';
require_once "./exception/alert.php";

class Auth{
    private $authQuery;
    private $alert;

    private $id;
    private $name;
    private $email;
    private $password;
    private $status;

    private $token;

    function __construct() {
        $this->authQuery = new AuthQuery();
        $this->alert = new Alert();

        $this->userId = 0;
        $this->name = "";
        $this->email = "";
        $this->password = "";
        $this->status = 0;

        $this->token = "";
    }
    //function login
    public function login($json){
        $data = json_decode($json, true);
        if(!isset($data['email']) || !isset($data['password'])){
            return $this->alert->clientError_400();
        }else{
            $email = $data['email'];
            $password = $this->authQuery->encryptPass($data['password']);
            $user = $this->authQuery->getUser($email);
            if($user){
                // si existe
                if($password == $user[0]['password']){
                    //consultamos si el usuario esta activo
                    if($user[0]['status'] == 1){
                        //creamos el token
                        $result = $this->authQuery->generateToken($user[0]['id']);
                        if($result){
                            $this->authQuery->desactivateToken($user[0]['id'], $result);
                            return $this->alert->customSuccess("Token '". $result. "' generated successfully");
                        }else{
                            return $this->alert->serverError_500();
                        }
                    }else{
                        //usuario inactivo
                        return $this->alert->customError("The user ". $email. " is inactive");
                    }
                }else{
                    //return "contra mala"; 
                    return $this->alert->customError("Invalid password");
                }
            }else{
                //no existe
                return $this->alert->customError("Username ". $email ." does not exist");
            }
        }
    }
}
?>