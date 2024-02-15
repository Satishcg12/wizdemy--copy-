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
            'users.user_type',
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
    public function edit()
    {
        $user = $this->model->find($_SESSION['user_id']);
        if (empty($user)) {
            $this->redirect('/404');
        }
        $this->view('editProfile', ['user' => $user]);
    }
    public function editPassword()
    {
        $user = $this->model->find($_SESSION['user_id']);
        $this->view('changePassword', ['user' => $user]);
    }
    public function updateProfileNameBio()
    {
        // update user name and bio
        $data = [
            'username' => $_POST['username'],
            'bio' => $_POST['bio']
        ];
        $validation = Validator::validate($data, [
            'username' => ['required', 'min:3', 'max:50'],
            'bio' => ['max:100']
        ]);
        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $this->redirect('/profile/edit/password');
        }
        
        if ($this->model->update($data, $_SESSION['user_id'])) {
            ToastNotification::success('Profile updated successfully');
            $this->redirect('/profile/edit/password');
        } else {
            ToastNotification::error($validation['msg']);
            $this->redirect('/profile/edit/password');
        }
    }
    public function updatePersonalInfo()
    {
        // update user personal info
        $data = [
            'full_name' => $_POST['full_name'],
            'user_type' => $_POST['user_type'],
            'education_level' => $_POST['education_level'],
            'enrolled_course' => $_POST['enrolled_course'],
            'school_name' => $_POST['school_name']
        ];
        $validation = Validator::validate($data, [
            'full_name' => ['required', 'min:3', 'max:50'],
            'user_type' => ['required'],
            'education_level' => ['required','min:2', 'max:50'],
            'enrolled_course' => ['required', 'min:3', 'max:50'],
            'school_name' => ['required', 'min:3', 'max:50']
        ]);
        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $this->redirect('/profile/edit/password');
        }
        if ($this->model->update($data, $_SESSION['user_id'])) {
            ToastNotification::success('Profile updated successfully');
            $this->redirect('/profile/edit/password');
        } else {
            ToastNotification::error($validation['msg']);
            $this->redirect('/profile/edit/password');
        }
    }
    public function updatePassword()
    {
        // print_r($_POST);
        // die();
        // update user password
        $data = [
            'password' => $_POST['password'],
            'new_password' => $_POST['new_password'],
            'confirm_password' => $_POST['confirm_password']
        ];
        $validation = Validator::validate($data, [
            'password' => ['required'],
            'new_password' => ['required', 'min:8', 'max:50'],
            'confirm_password' => ['required', 'min:8', 'max:50']
        ]);
        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $this->redirect('/profile/edit/password');
        }
        $user = $this->model->find($_SESSION['user_id']);
        if (!password_verify($data['password'], $user['password'])) {
            ToastNotification::error('Old password is incorrect');
            $this->redirect('/profile/edit/password');
        }
        if ($data['new_password'] != $data['confirm_password']) {
            ToastNotification::error('New password and confirm password does not match');
            $this->redirect('/profile/edit/password');
        }
        if ($this->model->update(['password' => password_hash($data['new_password'], PASSWORD_DEFAULT)], $_SESSION['user_id'])) {
            ToastNotification::success('Password updated successfully');
            $this->redirect('/profile/edit/password');
        } else {
            ToastNotification::error('Something went wrong');
            $this->redirect('/profile/edit/password');
        }
    }

    public function private()
    {   
        if (!isset($_POST['private'])) {
            $status = 0;
        }else{
            $status = $_POST['private'] == 'on' ? 1 : 0;
        }

        $data = [
            'private' => $status
        ];
        if ($this->model->update($data, $_SESSION['user_id'])) {
            ToastNotification::success('Profile updated successfully');
            $this->redirect('/profile/edit/password');
        } else {
            ToastNotification::error('Something went wrong');
            $this->redirect('/profile/edit/password');
        }
        
    }
}