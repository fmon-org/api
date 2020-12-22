<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MeController {
	public function getMyUser(): JsonResponse {
		return response()->json([
			'user' => Auth::user()
		]);
	}
}
