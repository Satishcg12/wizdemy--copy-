<?php
Router::get('/', 'HomeController@index');
Router::get('/login', 'AuthController@login', 'NoAuthMiddleware');
Router::post('/login', 'AuthController@loginProcess', ['CSRFMiddleware','NoAuthMiddleware']);
Router::get('/signup', 'AuthController@signup', 'NoAuthMiddleware');
Router::post('/signup', 'AuthController@signupProcess', ['NoAuthMiddleware','CSRFMiddleware']);
Router::get('/logout', 'AuthController@logout', 'AuthMiddleware');
Router::get('/profile', 'AuthController@profile', 'AuthMiddleware');

Router::get('/requests', 'RequestController@index', 'AuthMiddleware');
Router::get('/requests/create', 'RequestController@create', 'AuthMiddleware');
Router::post('/requests/store', 'RequestController@store', ['AuthMiddleware','CSRFMiddleware']);

Router::get('/upload', function(){
    View::render('upload');
});