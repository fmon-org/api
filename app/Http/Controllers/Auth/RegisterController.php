<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller {
	public function store(Request $request): JsonResponse {
		$this->validate($request, [
			'email' => 'required|email|unique:users',
			'username' => 'required|unique:users|min:3',
			'password' => 'required|confirmed|min:6'
		]);

		if (!$user = User::create($request->all())) {
			return response()->json([], 500);
		}

		ActivationController::initiateEmailActivation($user);

		$role = new UserRole();
		$role->creator_id = $user->id;
		$profile = new Profile();

		$user->role()->save($role);
		$user->profile()->save($profile);

		$user->save();

		return response()->json([
			'user' => $user
		]);
	}
}
