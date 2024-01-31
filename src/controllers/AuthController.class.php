<?php
class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct('User');
    }
    public function login()
    {
        $this->view('loginForm');
    }
    public function loginProcess()
    {
        
        $email_username = filter_var($_POST['email_username'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        
        Validator::make ([
            'email_username' => $email_username,
            'password' => $password
        ],[
            'email_username' => ['required'],
            'password' => ['required']
        ]);

        $response = $this->validateLoginForm($email_username, $password); 
        
        if(!$response['status']) {
            ToastNotification::error($response['msg']);
            $_SESSION['old'] = $_POST;
            $this->redirect('/login');
        }

        $user = new User();
        $result = $user->login($email_username, $password);
        if (!$result['status']) {
            ToastNotification::error($result['msg']);
            $_SESSION['old'] = $_POST;
            $this->redirect('/login');
        } else {
            $_SESSION['Auth'] = true;
            $_SESSION['user_id'] = $result['user_id'];
            ToastNotification::success($result['msg']);
            $this->redirect('/');
        }
    }
    public function logout()
    {
        if (isset($_SESSION['Auth'])) {
            unset($_SESSION['Auth']);
            unset($_SESSION['user_id']);
            ToastNotification::primary('You have been logged out');
        }
        header('location:/login');
    }
    public function signup()
    {
        if (isset($_SESSION['Auth'])) {
            header('location:/');
        } else {
            View::render('signupForm');
        }
    }
    public function signupProcess()
    {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $confirm_password = filter_var($_POST['confirmPassword'], FILTER_SANITIZE_STRING);
        $agree_terms_condition = $_POST['agree-terms-condition'] ?? '';
        

        $response = $this->validateSignupForm($name, $email, $password, $confirm_password, $agree_terms_condition);
        if(!$response['status']) {
            ToastNotification::error($response['msg']);
            $_SESSION['old'] = $_POST;
            $this->redirect('/signup');
        }

        $user = new User();
        $username = $this->generateUsername($email);
        $result = $user->signup($name, $username, $email, $password);
        if (!$result['status']) {
            ToastNotification::error($result['msg']);
            $_SESSION['old'] = $_POST;
            header('location:/signup');
        } else {
            ToastNotification::success($result['msg']);
            header('location:/login');
        }
    }
    private function validateLoginForm($email_username, $password)
    {
        if (empty($email_username) || empty($password)) {
            return [
                'status' => false,
                'msg' => 'Please fill all the fields'
            ];
        } else {
            return [
                'status' => true,
                'msg' => 'Success'
            ];
        }
    }
    private function validateSignupForm($name, $email, $password, $confirm_password, $agree_terms_conditions)
    {
        $user = new User();
        if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            return [
                'status' => false,
                'msg' => 'Please fill all the fields'
            ];
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => false,
                'msg' => 'Please enter a valid email'
            ];
        } else if ($user->emailExists($email)) {
            return [
                'status' => false,
                'msg' => 'Email already exists'
            ];
        }else if (strlen($password) < 8) {
            return [
                'status' => false,
                'msg' => 'Password must be at least 8 characters'
            ];
        }
        else if ($password !== $confirm_password) {
            return [
                'status' => false,
                'msg' => 'Password and confirm password does not match'
            ];
        } else if ($agree_terms_conditions !== 'on') {
            return [
                'status' => false,
                'msg' => 'Please agree to terms and conditions'
            ];
        } else {
            return [
                'status' => true,
                'msg' => 'Success'
            ];
        }
    }
    private function generateUsername(string $email): string
    {
        $username = explode('@', $email)[0];
        $user = new User();
        $usernameExists = $user->usernameExists($username);
        if ($usernameExists) {
            $username = $username . rand(1, 100);
        }
        return $username;
    }
}
