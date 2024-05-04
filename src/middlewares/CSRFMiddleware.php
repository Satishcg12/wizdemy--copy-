<?php

class CSRFMiddleware implements Middleware
{
    public function handle($request)
    {
        if (!CSRF::validateToken($request['csrf_token'])) {
            ToastNotification::warning('CSRF Token is invalid');
            header('location:/');
            exit();
        }
    }
}