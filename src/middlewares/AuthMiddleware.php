<?php
class AuthMiddleware implements Middleware
{
    public function handle($request)
    {
        if (!isset($_SESSION['Auth'])) {
            header('location:/login');
            exit();
        }
    }
}
