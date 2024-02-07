<?php
class HomeController extends Controller
{
     function __construct()
    {
        parent::__construct('StudyMaterial');
    }
    public function index()
    {
        $studyMaterials = $this->model->all();
        $this->view('index', ['studyMaterials' => $studyMaterials]);
    }
    
    public function create()
    {
        $this->view('createStudyMaterial');
    }

}