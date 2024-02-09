<?php
Router::get('/', 'HomeController@notes');
Router::get('/notes', 'HomeController@notes');
Router::get('/questions', 'HomeController@questions');
Router::get('/labreports', 'HomeController@labReports');

Router::get('/login', 'AuthController@login', 'NoAuthMiddleware');
Router::post('/login', 'AuthController@loginProcess', ['CSRFMiddleware','NoAuthMiddleware']);
Router::get('/signup', 'AuthController@signup', 'NoAuthMiddleware');
Router::post('/signup', 'AuthController@signupProcess', ['NoAuthMiddleware','CSRFMiddleware']);
Router::get('/logout', 'AuthController@logout', 'AuthMiddleware');

Router::get('/profile', 'UserController@profile', 'AuthMiddleware');

Router::get('/requests', 'RequestController@index');
Router::get('/requests/create', 'RequestController@create', 'AuthMiddleware');
Router::post('/requests/store', 'RequestController@store', ['AuthMiddleware','CSRFMiddleware']);

Router::get('/studymaterial/show', 'StudyMaterialController@show');
Router::post('/studymaterial/like', 'StudyMaterialController@like');
Router::post('/studymaterial/bookmark', 'StudyMaterialController@bookmark');
Router::get('/studymaterial/create', 'StudyMaterialController@create', 'AuthMiddleware');
Router::post('/studymaterial/store', 'StudyMaterialController@store', 'AuthMiddleware');