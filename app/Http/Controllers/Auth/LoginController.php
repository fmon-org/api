<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller {
	public function login(Request $request): JsonResponse {
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required'
		]);

		$user = User::where('username', $request->username)->first();

		if (is_null($user)) {
			return response()->json([
				'username' => trans(
					'validation.exists',
					['attribute' => trans('validation.attributes.username')]
				)
			], 401);
		}

		if (!$user->isActive()) {
			return response()->json([
				'user' => trans(
					'validation.activated',
					['attribute' => trans('validation.attributes.user')]
				)
			], 401);
		}

		if (!$user->checkPassword($request->password)) {
			return response()->json([
				'password' => trans(
					'validation.same',
					[
						'attribute' => trans('validation.attributes.password'),
						'other' => trans('validation.attributes.username')
					]
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
