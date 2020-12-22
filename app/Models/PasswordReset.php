<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {
	protected string $table = 'password_resets';
	protected array $fillable = ['token', 'user_id'];
}
