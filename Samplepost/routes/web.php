<?php

/** @var \Laravel\Lumen\Routing\Router $router */

//use App\Http\Controllers\CreatePostController;


$router->post('/post', [
    'as' => 'post', 'uses' => 'CreatePostController@createPost'
]);
$router->get('/post/{post_id}', [
    'as' => 'post', 'uses' => 'CreatePostController@getPost'
]);
