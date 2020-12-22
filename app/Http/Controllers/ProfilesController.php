<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfilesController extends Controller {
	protected string $avatar_path = 'images/avatar/';

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
			'avatar' => 'file|required'
		]);

		$profile = Auth::user()->profile()->first();

		if($profile->avatar) {
			unlink(storage_path($profile->avatarName($this->avatar_path)));
		}

		$avatar_name = Str::uuid()->toString().'.jpg';
		$request->avatar->move(storage_path($this->avatar_path), $avatar_name);
		$profile->avatar = $avatar_name;
		$profile->save();

		return response()->json([
			'profile' => $profile
		]);
	}
}
