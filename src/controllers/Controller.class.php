<?php

class Controller{
    protected $model;

    public function __construct(){
        $this->model = new Model;
    }
    public function redirect ($url){
        header('Location: ' . $url);
        exit();
    }
    public function view($view, $data = []){
        View::render($view, $data);
    }

    // for api
    public function json($data){
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}