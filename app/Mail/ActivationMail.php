<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class ActivationMail extends Mailable {
	use Queueable, SerializesModels;

	protected $token;

	public function __construct(string $token) {
		$this->token = $token;
	}

	public function build() {
		$token = $this->token;

		return $this->subject(Lang::get('mail.activation'))
			->from(env('MAIL_FROM_ADDRESS'))
			->view('emails.activation', compact('token'));
	}
}
