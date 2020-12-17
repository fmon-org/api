<a href="{{ env('APP_URL') }}/api/reset_password/{{ $token }}">
	{{ \Illuminate\Support\Facades\Lang::get('mail.reset_password_link') }}
</a>
