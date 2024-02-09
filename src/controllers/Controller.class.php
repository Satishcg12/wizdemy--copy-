<?php

class Controller{
    /**
     * @var Model 
     */
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
    public function back(){
        if (isset($_SERVER['HTTP_REFERER'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: /');
        }
        exit();
    }
    protected function view($view, $data = []){
        View::render($view, $data);
    }

    // for api
    protected function json($data){
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

}