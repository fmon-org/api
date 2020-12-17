<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller {
	public function login(Request $request): JsonResponse {
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required'
		]);

		$user = User::where('username', $request->username)->first();

		if (is_null($user)) {
			return response()->json([
				'username' => Lang::get(
					'validation.exists',
					['attribute' => 'username']
				)
			], 401);
		}

		if (!$user->activated) {
			return response()->json([
				'user' => Lang::get(
					'validation.activated',
					['attribute' => 'user']
				)
			], 401);
		}

		if (!$user->checkPassword($request->password)) {
			return response()->json([
				'password' => Lang::get(
					'validation.same',
					['attribute' => 'password', 'other' => 'username']
				)
			], 401);
		}

		$token = JWT::encode(
			['id' => $user['id']],
			env('JWT_KEY')
		);

		return response()->json([
			"token" => $token,
			"user" => $user
		]);
	}
}
