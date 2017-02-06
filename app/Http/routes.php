<?php
// Demo
$app->get('/demo', 'DemoController@index');
$app->get('/demo/feed', 'DemoController@feed');

// Instagram
$app->get('/instagram/authenticate', 'InstagramController@authenticate');
$app->get('/instagram/requestAuthToken', 'InstagramController@requestAuthToken');
