<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivationMail;
use App\Models\Activation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ActivationController extends Controller {
	static public function initiateEmailActivation(User $user): void {
		$activation_token = Str::uuid()->toString();

		Activation::create([
			'user_id' => $user->id,
			'token' => $activation_token
		]);

		Mail::to($user->email)->send(new ActivationMail($activation_token));
	}

	public function activate(string $token): JsonResponse {
		$activation = Activation::where('token', $token)->first();

		if (is_null($activation)) {
			return response()->json([
				'token' => Lang::get(
					'validation.exists',
					['attribute' => 'token']
				)
			], 404);
		}

		User::where('id', $activation->user_id)
			->update(['activated' => true]);

		$activation->delete();

		return response()->json([
			'user' => Lang::get(
				'alert.activated',
				['attribute' => 'user']
			)
		]);
	}
}
