<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class PasswordResetMail extends Mailable {
	use Queueable, SerializesModels;

	protected $token;

	public function __construct(string $token) {
		$this->token = $token;
	}

	public function build() {
		$token = $this->token;

		return $this->subject(Lang::get('mail.reset_password'))
			->from(env('MAIL_FROM_ADDRESS'))
			->view('emails.reset_password', compact('token'));
	}
}
