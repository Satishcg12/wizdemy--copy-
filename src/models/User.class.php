<?php
class User extends Database
{
    public function __construct()
    {
        parent::__construct();
    }
    public function login(string $username, string $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        if (!$user) {
            return [
                'status' => false,
                'msg' => 'User not found'
            ];
        }
        if (password_verify($password, $user['password'])) {
            return [
                'status' => true,
                'user_id' => $user['id'],
                'msg' => 'Login successful'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Incorrect password'
            ];
        }
    }
    public function signup(string $full_name, $username, string $email, string $password)
    {
        $cost = ['cost' => 12];
        $password = password_hash($password, PASSWORD_BCRYPT, $cost);

        $stmt = $this->pdo->prepare('INSERT INTO users (full_name, username, email, password) VALUES (:full_name, :username, :email, :password)');
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $res = $stmt->execute();
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
    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user) {
            return true;
        }
        return false;
    }
    public function usernameExists(string $username): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user) {
            return true;
        }
        return false;
    }

    public function getUserById(int $user_id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $user_id]);
        $user = $stmt->fetch();
        if ($user) {
            return $user;
        }
        return false;
    }
    public function getUserByUsername(string $username)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user) {
            return $user;
        }
        return false;
    }
    public function getUserByEmail(string $email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user) {
            return $user;
        }
        return false;
    }
    public function updateProfile(int $user_id, string $full_name, string $username, string $email, string $bio)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET full_name = :full_name, username = :username, email = :email, bio = :bio WHERE id = :id');
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':id', $user_id);
        $res = $stmt->execute();
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Profile updated successfully'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Profile update failed'
            ];
        }
    }
    public function updatePassword(int $user_id, string $password)
    {
        $cost = ['cost' => 12];
        $password = password_hash($password, PASSWORD_BCRYPT, $cost);
        $stmt = $this->pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $user_id);
        $res = $stmt->execute();
        if ($res) {
            return [
                'status' => true,
                'msg' => 'Password updated successfully'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Password update failed'
            ];
        }
    }
}