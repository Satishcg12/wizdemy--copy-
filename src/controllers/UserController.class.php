<?php

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct('Users');

    }
    public function profile()
    {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
        } else {
            $userId = $_SESSION['user_id'];
        }

        //get user data with post count
        $user = $this->model->select([
            'users.id',
            'users.username',
            'users.full_name',
            'users.bio',
            'users.created_at',
            'users.education_level',
            'users.email',
            'users.private',
            'COUNT(study_materials.id) as post_count',
        ])
            ->leftJoin('study_materials', 'users.id', '=', 'study_materials.user_id')
            ->where('users.id', $userId)
            ->groupBy('users.id')
            ->first();
        // get user followers
        $userFollows = new UserFollows();
        $followers = $userFollows->where('following_id', $userId)->count();
        // get user following
        $following = $userFollows->where('follower_id', $userId)->count();
        // get user study materials with user joint and arrange by latest with view ,comments and likes count
        $studyMaterial = (new StudyMaterial())->select([
            'study_materials.*',
            'users.username as user_name',
            'COUNT(views.id) as views_count',
            'COUNT(comments.id) as comments_count',
            'COUNT(likes.id) as likes_count'
        ])
            ->join('users', 'study_materials.user_id', '=', 'users.id')
            ->leftJoin('views', 'study_materials.id', '=', 'views.study_material_id')
            ->leftJoin('comments', 'study_materials.id', '=', 'comments.study_material_id')
            ->leftJoin('likes', 'study_materials.id', '=', 'likes.study_material_id')
            ->where('study_materials.user_id', $userId)
            ->groupBy('study_materials.id')
            ->orderBy('study_materials.created_at', 'DESC')
            ->get();

        $this->view('profile', [
            'user' => $user,
            'studyMaterials' => $studyMaterial,
            'followers' => $followers,
            'following' => $following
        ]);
    }
}