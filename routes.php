<?php
Router::get('/', 'HomeController@notes');
Router::get('/notes', 'HomeController@notes');
Router::get('/questions', 'HomeController@questions');
Router::get('/labreports', 'HomeController@labReports');


Router::get('/likes', 'HomeController@likes', 'AuthMiddleware');  
Router::get('/saved', 'HomeController@saved', 'AuthMiddleware');  
Router::get('/search', 'HomeController@saved', 'AuthMiddleware');  
Router::get('/search/suggest', 'SearchController@suggest');  

Router::get('/login', 'AuthController@login', 'NoAuthMiddleware');
Router::post('/login', 'AuthController@loginProcess', ['CSRFMiddleware','NoAuthMiddleware']);
Router::get('/signup', 'AuthController@signup', 'NoAuthMiddleware');
Router::post('/signup', 'AuthController@signupProcess', ['NoAuthMiddleware','CSRFMiddleware']);
Router::get('/logout', 'AuthController@logout', 'AuthMiddleware');

Router::get('/profile', 'UserController@profile', 'AuthMiddleware');
Router::get('/profile/edit', 'UserController@edit', 'AuthMiddleware');
Router::get('/profile/edit/password', 'UserController@editPassword', 'AuthMiddleware');
Router::post('/profile/edit/password', 'UserController@updatePassword', 'AuthMiddleware');
Router::post('/profile/edit/private', 'UserController@private', 'AuthMiddleware');
Router::post('/profile/edit/namebio', 'UserController@updateProfileNameBio', 'AuthMiddleware');
Router::post('/profile/edit/info', 'UserController@updatePersonalInfo', 'AuthMiddleware');

Router::get('/requests', 'RequestController@index');
Router::get('/requests/create', 'RequestController@create', 'AuthMiddleware');
Router::post('/requests/store', 'RequestController@store', ['AuthMiddleware','CSRFMiddleware']);

Router::get('/studymaterial/show', 'StudyMaterialController@show');
Router::get('/studymaterial/create', 'StudyMaterialController@create', 'AuthMiddleware');
Router::post('/studymaterial/store', 'StudyMaterialController@store', 'AuthMiddleware');


Router::post('/studymaterial/like', 'LikeController@like', 'AuthMiddleware');
Router::post('/studymaterial/bookmark', 'BookmarkController@bookmark', 'AuthMiddleware');
Router::post('/studymaterial/comment', 'CommentController@create', 'AuthMiddleware');