<?php

namespace App\Providers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	public function register(): void {
		//
	}

	public function boot(): void {
		$this->app['auth']->viaRequest('api', function (Request $request) {
			if (!$request->hasHeader('Authorization')) {
				return null;
			}

			$authorization = $request->header('Authorization');
			$token = str_replace('Bearer ', '', $authorization);

			$authentication = JWT::decode($token, env('JWT_KEY'), ['HS256']);

			return User::where('id', $authentication->id)
				->where('activated', true)
				->first();
		});
	}
}
