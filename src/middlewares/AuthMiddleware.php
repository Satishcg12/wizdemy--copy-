<?php
class AuthMiddleware implements Middleware
{
    public function handle()
    {
        if (!isset($_SESSION['Auth']) || !$_SESSION['Auth']) {
            header('Location: /login');
            exit();            
        }
    }
}
