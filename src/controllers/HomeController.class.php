<?php
class HomeController extends Controller
{
    function __construct()
    {
        parent::__construct('StudyMaterial');
    }
    public function notes()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // get all notes with user joint, arrange by latest with view ,comments and likes count
        // notes of following users only
        //include current user notes
        
        
        if (isset($_SESSION['user_id'])) {
            $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
                ->join('users', 'study_materials.user_id', '=', 'users.id')
                ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
                ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
                ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
                ->leftJoin('user_follows', 'study_materials.user_id', '=', 'user_follows.following_id')
                ->where('study_materials.document_type', 'note')
                ->where('users.private', 0)
                ->where('user_follows.follower_id', $_SESSION['user_id'])
                ->orWhere('study_materials.user_id', $_SESSION['user_id'])
                ->groupBy('study_materials.id')
                ->orderBy('study_materials.created_at', 'DESC')
                ->limit(10)
                ->offset(($page - 1) * 10)
                ->get();
        } else {
            $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
                ->join('users', 'study_materials.user_id', '=', 'users.id')
                ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
                ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
                ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
                ->where('study_materials.document_type', 'note')
                ->andWhere('users.private', 0)
                ->groupBy('study_materials.id')
                ->orderBy('study_materials.created_at', 'DESC')
                ->limit(10)
                ->offset(($page - 1) * 10)
                ->get();
        }
        $this->view('notes', ['studyMaterials' => $response]);
    }
    public function questions()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // get all questions with user joint, arrange by latest with view ,comments and likes count
        if (isset($_SESSION['user_id'])) {
            $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
                ->join('users', 'study_materials.user_id', '=', 'users.id')
                ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
                ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
                ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
                ->leftJoin('user_follows', 'study_materials.user_id', '=', 'user_follows.following_id')
                ->where('study_materials.document_type', 'question')

                ->orWhere('study_materials.user_id', $_SESSION['user_id'])
                ->where('user_follows.follower_id', $_SESSION['user_id'])
                ->groupBy('study_materials.id')
                ->orderBy('study_materials.created_at', 'DESC')
                ->limit(10)
                ->offset(($page - 1) * 10)
                ->get();
        } else {
            $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
                ->join('users', 'study_materials.user_id', '=', 'users.id')
                ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
                ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
                ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
                ->where('study_materials.document_type', 'question')
                ->where('users.private', 0)
                ->groupBy('study_materials.id')
                ->orderBy('study_materials.created_at', 'DESC')
                ->limit(10)
                ->offset(($page - 1) * 10)
                ->get();
        }
        $this->view('questions', ['studyMaterials' => $response]);
    }
    public function labReports()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // get all lab reports with user joint, arrange by latest with view ,comments and likes count
        if (isset($_SESSION['user_id'])) {
            $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
                ->join('users', 'study_materials.user_id', '=', 'users.id')
                ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
                ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
                ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
                ->leftJoin('user_follows', 'study_materials.user_id', '=', 'user_follows.following_id')
                ->where('study_materials.document_type', 'lab report')
                ->where('users.private', 0)
                ->orWhere('study_materials.user_id', $_SESSION['user_id'])
                ->where('user_follows.follower_id', $_SESSION['user_id'])
                ->groupBy('study_materials.id')
                ->orderBy('study_materials.created_at', 'DESC')
                ->limit(10)
                ->offset(($page - 1) * 10)
                ->get();
        } else {
            $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
                ->join('users', 'study_materials.user_id', '=', 'users.id')
                ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
                ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
                ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
                ->where('study_materials.document_type', 'lab report')
                ->where('users.private', 0)
                ->groupBy('study_materials.id')
                ->orderBy('study_materials.created_at', 'DESC')
                ->limit(10)
                ->offset(($page - 1) * 10)
                ->get();
        }

        $this->view('labReports', ['studyMaterials' => $response]);
    }
    public function likes(){
        $page =isset($_GET['page'])?$_GET['page']:1;
        // get all liked study materials by user
        $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
        ->join('users', 'study_materials.user_id', '=', 'users.id')
        ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
        ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
        ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
        ->where('likes.user_id',$_SESSION['user_id'])
        ->groupBy('study_materials.id')
        ->orderBy('likes.created_at', 'DESC')
        ->limit(10)
        ->offset(($page - 1) * 10)
        ->get();
        $this->view('likes', ['studyMaterials' => $response]);
    }
    public function saved(){
        $page =isset($_GET['page'])?$_GET['page']:1;
        // get all saved study materials by user
        $response = $this->model->select(['study_materials.*', 'users.username as user_name', 'COUNT(views.id) as views_count', 'COUNT(comments.id) as comments_count', 'COUNT(likes.id) as likes_count'])
        ->join('users', 'study_materials.user_id', '=', 'users.id')
        ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
        ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
        ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
        ->leftJoin('bookmarks', 'study_materials.id', '=', 'bookmarks.study_material_id')
        ->where('bookmarks.user_id',$_SESSION['user_id'])
        ->groupBy('study_materials.id')
        ->orderBy('bookmarks.created_at', 'DESC')
        ->limit(10)
        ->offset(($page - 1) * 10)
        ->get();
        $this->view('saved', ['studyMaterials' => $response]);
    }
    public function create()
    {
        $this->view('createStudyMaterial');
    }

}