<?php
class Users extends Model
{
    public function __construct()
    {
        parent::__construct('users');
        $this->fillable = [
            'full_name',
            'username',
            'email',
            'password',
            'bio',
            'user_type',
            'education_level',
            'private',
            'enrolled_course',
            'school_name'
        ];
    }
    public function login(string $username, string $password)
    {
        $res = $this->select(['id', 'password'])->where('username', $username)->orWhere('email', $username)->get();
        if ($res) {
            $user = $res[0];
            if (password_verify($password, $user['password'])) {
                return [
                    'status' => true,
                    'msg' => 'Login successful',
                    'user' => $user
                ];
            } else {
                return [
                    'status' => false,
                    'msg' => 'Invalid password'
                ];
            }
        } else {
            return [
                'status' => false,
                'msg' => 'User not found'
            ];
        }
    }
    public function signup(string $full_name, $username, string $email, string $password)
    {
        $cost = ['cost' => 12];
        $password = password_hash($password, PASSWORD_BCRYPT, $cost);
        $res = $this->create([
            'full_name' => $full_name,
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        if ($res) {
            return [
                'status' => true,
                'msg' => 'Signup successful'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Signup failed'
            ];
        }
    }
}