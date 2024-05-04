<?php
class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct('Users');
    }
    public function login()
    {
        $this->view('loginForm');
    }
    public function loginProcess()
    {

        $email_username = $_POST['email_username'];
        $password = $_POST['password'];

        $validation = Validator::validate([
            'email_username' => $email_username,
            'password' => $password
        ], [
            'email_username' => ['required', 'min:3'],
            'password' => ['required', 'min:8']
        ]);
        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $_SESSION['old'] = $_POST;
            $this->redirect('/login');
        }

        $result = $this->model->login($email_username, $password);
        if (!$result['status']) {
            ToastNotification::error($result['msg']);
            $_SESSION['old'] = $_POST;
            $this->redirect('/login');
        } else {
            $_SESSION['Auth'] = true;
            $_SESSION['user_id'] = $result['user']['id'];
            ToastNotification::success($result['msg']);
            $this->back();
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
        $name = $_POST['name'];
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmPassword'];
        $agree_terms_condition = $_POST['agree-terms-condition'] ?? '';

        $validation = Validator::validate([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirm_password,
            'agree-terms-condition' => $agree_terms_condition
        ], [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed', 'max:255'],
            'password_confirmation' => ['required', 'max:255'],
            'agree-terms-condition' => ['required']
        ]);

        if (!$validation['status']) {
            foreach ($validation['msg'] as $msg) {
                ToastNotification::error($msg);
            }
            $_SESSION['old'] = $_POST;
            $this->redirect('/signup');
        }
        $username = $this->generateUsername($email);
        $result = $this->model->signup($name, $username, $email, $password);
        if (!$result['status']) {
            ToastNotification::error($result['msg']);
            $_SESSION['old'] = $_POST;
            header('location:/signup');
        } else {
            ToastNotification::success($result['msg']);
            header('location:/login');
        }
    }

    private function generateUsername(string $email): string
    {
        do {
            $username = explode('@', $email)[0];
            $usernameExists = $this->model->exists('username', $username);
            if ($usernameExists) {
                $username = $username . rand(1, 100);
            }
        } while ($usernameExists);
        return $username;
    }
}
