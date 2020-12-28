<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model {
	protected string $table = 'user_role';
	protected array $fillable = ['user_id', 'role_id'];
	protected array $hidden = ['creator_id', 'user_id', 'id'];
	protected array $appends = ['role_label'];

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	public function role(): BelongsTo {
		return $this->belongsTo(Role::class);
	}

	public function creator(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	public function getRole(): Role {
		return Role::where('id', $this->attributes['role_id'])
			->first();
	}

	public function getRoleLabelAttribute($role_label) {
		return $this->getRole()->label;
	}
}
