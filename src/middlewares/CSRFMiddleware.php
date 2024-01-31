<?php

class CSRFMiddleware implements Middleware
{
    public function handle($request)
    {
        if (!CSRF::validateToken($request['csrf_token'])) {
            header('location:/');
            exit();
        }
    }
}