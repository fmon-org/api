<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResets extends Controller {
	public function forgot(Request $request): JsonResponse {
		$this->validate($request, [
			'email' => 'required|email',
		]);

		$user = User::where(['email' => $request->email])->first();

		if (is_null($user)) {
			return response()->json([
				'email ' => Lang::get(
					'validation.exists',
					['attribute' => 'email']
				)
			], 404);
		}
		$reset_token = Str::uuid()->toString();

		PasswordReset::create([
			'user_id' => $user->id,
			'token' => $reset_token
		]);

		Mail::to($user->email)->send(new PasswordResetMail($reset_token));

		return response()->json([
			'password' => Lang::get(
				'mail.sent'
			)
		]);
	}

	public function reset(string $token, Request $request) {
		$this->validate($request, [
			'password' => 'required|confirmed|min:6'
		]);

		$resets = PasswordReset::where(['token' => $token])->first();

		if (is_null($resets)) {
			return response()->json([
				'token' => Lang::get(
					'validation.exists',
					['attribute' => 'token']
				)
			], 404);
		}

		$user = User::where('id', $resets->user_id)->first();
		$user->password = $request->password;
		$user->save();

		$resets->delete();

		return response()->json([
			'user' => Lang::get(
				'alert.updated',
				['attribute' => 'password']
			)
		]);
	}
}
