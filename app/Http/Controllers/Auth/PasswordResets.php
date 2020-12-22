<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
				'email ' => trans(
					'validation.exists',
					['attribute' => trans('validation.attributes.email')]
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
			'password' => trans(
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
				'token' => trans(
					'validation.exists',
					['attribute' => trans('validation.attributes.token')]
				)
			], 404);
		}

		$user = User::where('id', $resets->user_id)->first();
		$user->password = $request->password;
		$user->save();

		$resets->delete();

		return response()->json([
			'user' => trans(
				'alert.updated',
				['attribute' => trans('validation.attributes.password')]
			)
		]);
	}
}
