<?php

class Alert{

    private $response = [
        "result" => array()
    ];

    public function customSuccess($string){
        $this->response['result'] = array(
            "status" =>"Ok",
            "code" =>"200",
            "msg" => $string
        );
        return $this->response;
    }

    public function customError($string){
        $this->response['result'] = array(
            "status" =>"Error",
            "code" =>"400",
            "msg" => $string
        );
        return $this->response;
    }

    public function clientError_400(){
        $this->response['result'] = array(
            "status" =>"Error",
            "code" =>"400",
            "msg" => "Bad Request"
        );
        return $this->response;
    }

    public function clientError_401(){
        $this->response['result'] = array(
            "status" =>"Error",
            "code" =>"401",
            "msg" => "Unauthorized4"
        );
        return $this->response;
    }

    public function clientError_404(){
        $this->response['result'] = array(
            "status" =>"Error",
            "code" =>"404",
            "msg" => "Not Found"
        );
        return $this->response;
    }

    public function clientError_405(){
        $this->response['result'] = array(
            "status" =>"Error",
            "code" =>"405",
            "msg" => "Method not allowed"
        );
        return $this->response;
    }

    public function serverError_500(){
        $this->response['result'] = array(
            "status" =>"Error",
            "code" =>"500",
            "msg" => 'Internal Server Error'
        );
        return $this->response;
    }
}

?>