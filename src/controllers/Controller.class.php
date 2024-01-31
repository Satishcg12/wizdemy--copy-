<?php

class Controller{
    protected $model;

    protected function __construct($modelName){
        if (!class_exists($modelName)){
            throw new Exception("Model class $modelName not found!");
        }
        $this->model = new $modelName();
    }
    protected function redirect ($url){
        header('Location: ' . $url);
        exit();
    }
    protected function view($view, $data = []){
        View::render($view, $data);
    }
    //verify csrf token
    protected function verifyCsrf(){
        if (!CSRF::validateToken($_POST['csrf_token'])){
            ToastNotification::error('Invalid CSRF token');
            $_SESSION['old'] = $_POST;
            header('location:/login');
            exit();
        }
    }

    // validate form data
    protected function validateEmail($email){
        if (empty($email)){
            return ['status' => false, 'msg' => 'Email is required'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return ['status' => false, 'msg' => 'Email is invalid'];
        }
        return ['status' => true];
    }
    protected function validateInput($input, $min, $max, $name){
        if (empty($input)){
            return ['status' => false, 'msg' => "$name is required"];
        }
        if (strlen($input) < $min){
            return ['status' => false, 'msg' => "$name must be at least $min characters"];
        }
        if (strlen($input) > $max){
            return ['status' => false, 'msg' => "$name must be less than $max characters"];
        }
        return ['status' => true];
    }
    

    // for api
    protected function json($data){
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}