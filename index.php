<?php
//strict type
declare(strict_types=1); 
// show error log
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/utils/ClassAutoloader.php';
require_once __DIR__ . '/src/utils/session.config.php';

$request = parse_url($_SERVER['REQUEST_URI'])['path'];

require_once __DIR__ . '/routes.php';

try{
    Router::dispatch($_SERVER['REQUEST_METHOD'], $request);    
} catch (Exception $e) {
    if ($e->getCode() == 404) {
        View::render('404');
    } else {
        echo $e->getMessage();
    }

}
if (isset($_SESSION['old']))unset($_SESSION['old']);