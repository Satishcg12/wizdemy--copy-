<?php 
class NoAuthMiddleware implements Middleware
{
    public function handle($request)
    {
        if (isset($_SESSION['Auth'])) {
            header('location:/');
            exit();
        }
    }
}