<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group([
	'prefix' => 'api',
	'middleware' => 'locale'
], function () use ($router) {
	$router->get('', function () {
		return env('APP_NAME') . ' is available';
	});

	$router->post('login', 'Auth\LoginController@login');
	$router->post('register', 'Auth\RegisterController@store');
	$router->post('forgotPassword', 'Auth\PasswordResets@forgot');
	$router->post('resetPassword/{token}', 'Auth\PasswordResets@reset');
	$router->get('activate/{token}', 'Auth\ActivationController@activate');

	$router->group(['prefix' => 'users'], function () use ($router) {
		$router->get('', 'UsersController@index');
		$router->get('{id}', 'UsersController@show');
	});

	$router->group(
		['middleware' => 'auth'],
		function () use ($router) {
			$router->patch('user', 'UsersController@update');
			$router->patch('profile', 'ProfilesController@update');
			$router->post('profile/newAvatar', 'ProfilesController@updateAvatar');
		}
	);
});
