<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ProfilesController extends Controller {
	public function update(Request $request): JsonResponse {
		$this->validate($request, [
			'location' => 'string',
			'steam' => 'string',
			'epic_games' => 'string',
		]);

		$profile = Auth::user()->profile()->first();
		$profile->fill($request->all());
		$profile->save();

		return response()->json([
			'profile' => $profile
		]);
	}

	public function updateAvatar(Request $request): JsonResponse {
		$this->validate($request, [
			'avatar' => 'file'
		]);

		if (!$request->hasFile('avatar')) {
			return response()->json([
				'avatar' => Lang::get(
					'validation.required',
					['attribute' => 'avatar']
				)
			], 422);
		}

		$profile = Auth::user()->profile()->first();
		$avatar_name = uniqid($profile->user_id) . '.jpg';

		$request->avatar->move('images/avatar', $avatar_name);
		$profile->avatar = $avatar_name;
		$profile->save();

		return response()->json([
			'profile' => $profile
		]);
	}
}
