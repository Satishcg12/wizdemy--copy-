<?php 
class NoAuthMiddleware implements Middleware
{
    public function handle()
    {
        if (isset($_SESSION['Auth'])) {
            header('location:/');
            exit();
        }
    }
}