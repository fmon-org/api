<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	protected string $table = 'roles';
	protected array $fillable = ['id', 'label'];
}
