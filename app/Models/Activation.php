<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model {
	protected string $table = 'user_activation';
	protected array $fillable = ['token', 'user_id'];
}
