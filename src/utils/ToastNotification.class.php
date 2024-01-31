<?php

class ToastNotification
{
    public static function show($message, $type = 'primary', $duration = 5000)
    {
        $_SESSION['toastMessage'] = [
            'message' => $message,
            'type' => $type,
            'duration' => $duration
        ];
    }
    public static function primary($message, $duration = 5000)
    {
        $_SESSION['toastMessage'] = [
            'message' => $message,
            'type' => 'primary',
            'duration' => $duration
        ];
    }
    public static function error($message, $duration = 5000)
    {
        $_SESSION['toastMessage'] = [
            'message' => $message,
            'type' => 'error',
            'duration' => $duration
        ];
    }
    public static function success($message, $duration = 5000)
    {
        $_SESSION['toastMessage'] = [
            'message' => $message,
            'type' => 'success',
            'duration' => $duration
        ];
    }
    public static function warning($message, $duration = 5000)
    {
        $_SESSION['toastMessage'] = [
            'message' => $message,
            'type' => 'warning',
            'duration' => $duration
        ];
    }
}
