<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale {
	public function handle(Request $request, Closure $next) {
		if (!$request->hasHeader('Accept-Language')) {
			return $next($request);
		}

		app()->setLocale($request->header('Accept-Language'));

		return $next($request);
	}
}
