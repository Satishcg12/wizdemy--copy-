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

$request = $_SERVER['REQUEST_URI'];  

// Remove any query parameters
if (($pos = strpos($request, '?')) !== false) {
    $request = substr($request, 0, $pos);
}

// $request = parse_url($_SERVER['REQUEST_URI'])['path'];

$route = new Router();


$route->get('/', 'HomeController@index');
$route->get('/login', 'AuthController@login', 'NoAuthMiddleware');
$route->post('/login', 'AuthController@loginProcess', ['CSRFMiddleware','NoAuthMiddleware']);
$route->get('/signup', 'AuthController@signup', 'NoAuthMiddleware');
$route->post('/signup', 'AuthController@signupProcess', 'NoAuthMiddleware');
$route->get('/logout', 'AuthController@logout', 'AuthMiddleware');
$route->get('/profile', 'AuthController@profile', 'AuthMiddleware');



try{
    $route->dispatch($_SERVER['REQUEST_METHOD'], $request);

    
} catch (Exception $e) {
    if ($e->getCode() == 404) {
        View::render('404');
    } else {
        echo $e->getMessage();
    }

}

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

if (isset($_SESSION['old']))unset($_SESSION['old']);