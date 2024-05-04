<?php
Router::get('/', 'HomeController@index');
Router::post('/test', function () {
    print_r($_POST);
});
Router::get('/login', 'AuthController@login', 'NoAuthMiddleware');
Router::post('/login', 'AuthController@loginProcess', ['CSRFMiddleware','NoAuthMiddleware']);
Router::get('/signup', 'AuthController@signup', 'NoAuthMiddleware');
Router::post('/signup', 'AuthController@signupProcess', ['NoAuthMiddleware','CSRFMiddleware']);
Router::get('/logout', 'AuthController@logout', 'AuthMiddleware');
Router::get('/profile', 'AuthController@profile', 'AuthMiddleware');

Router::get('/requests', 'RequestController@index');
Router::get('/requests/create', 'RequestController@create', 'AuthMiddleware');
Router::post('/requests/store', 'RequestController@store', ['AuthMiddleware','CSRFMiddleware']);

Router::get('/studymaterial/create', 'StudyMaterialController@create', 'AuthMiddleware');
Router::post('/studymaterial/store', 'StudyMaterialController@store', 'AuthMiddleware');