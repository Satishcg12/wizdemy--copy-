<?php
class CSRF {
    public static function generateToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateToken($token) {
        if (isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token']) {
            unset($_SESSION['csrf_token']); // Token is used once, so regenerate it
            return true;
        }
        return false;
    }
}