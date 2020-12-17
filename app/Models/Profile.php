<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model {
	protected string $table = 'profiles';
	protected array $fillable = ['steam', 'epic_games', 'location', 'avatar'];
	protected array $hidden = ['id', 'user_id'];

	public function getAvatarAttribute($avatar): ?string {
		return $avatar ?
			env('APP_URL') . '/images/avatar/' . $avatar
			: null;
	}

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}
}
