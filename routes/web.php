<?php

$router->group(['prefix' => 'api'], function($router)
{
    $router->get('/continent/', 'apiController@getContinent');
    $router->get('/country/', 'apiController@getCountry');
    $router->get('/state/', 'apiController@getState');
    $router->get('/city/', 'apiController@getCity');
	$router->get('/auth', 'AuthController@getToken');
	$router->get('/test',function()
	{
		return response()->json([
			"statusCode" => 200,
			"message" => "successfully tested"
		],200);
	});
});
