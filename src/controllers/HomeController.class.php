<?php
class HomeController extends Controller
{
     function __construct()
    {
        parent::__construct('StudyMaterial');
    }
    public function notes()
    {
        // get all notes with user joint, arrange by latest with view ,comments and likes count
        $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
            ->join('users', 'study_materials.user_id', '=', 'users.id')
            ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
            ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
            ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
            ->where('study_materials.document_type', 'note')
            ->groupBy('study_materials.id')
            ->orderBy('study_materials.created_at', 'DESC')
            ->get();
        $this->view('notes', ['studyMaterials' => $response]);
    }
    public function questions()
    {
        $response = $this->model->select(['study_materials.*', 'users.username as user_name'])
            ->join('users', 'study_materials.user_id', '=', 'users.id')
            ->where('study_materials.document_type', 'questions')
            ->orderBy('study_materials.created_at', 'DESC')
            ->get();
        $this->view('questions', ['studyMaterials' => $response]);
    }
    public function labReports()
    {
        $response = $this->model->select(['study_materials.*', 'users.username as user_name'])
            ->join('users', 'study_materials.user_id', '=', 'users.id')
            ->where('study_materials.document_type', 'lab_reports')
            ->orderBy('study_materials.created_at', 'DESC')
            ->get();
        $this->view('labReports', ['studyMaterials' => $response]);
    }
    
    public function create()
    {
        $this->view('createStudyMaterial');
    }

}