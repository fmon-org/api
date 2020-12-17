<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller {
	public function index(Request $request) {
		return User::paginate($request->per_page);
	}

	public function show(int $id) {
		if (!$user = User::find($id)) {
			return response()->json([], 204);
		}

		return response()->json([
			'user' => $user
		]);
	}

	public function update(Request $request): JsonResponse {
		$this->validate($request, [
			'email' => 'email|unique:users',
			'username' => 'unique:users|min:3',
			'password' => 'confirmed|min:6|password:api'
		]);

		$user = Auth::user();
		$user->fill($request->all());
		$user->save();

		return response()->json([
			'user' => $user
		]);
	}
}
