<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract {
	use Authenticatable, Authorizable, HasFactory;

	protected string $table = 'users';
	protected array $fillable = ['username', 'email', 'password'];
	protected array $hidden = ['password', 'activated'];
	protected array $appends = ['profile', 'roles'];

	public function profile(): HasOne {
		return $this->hasOne(Profile::class);
	}

	public function role(): HasOne {
		return $this->hasOne(UserRole::class);
	}

	public function roles(): HasMany {
		return $this->hasMany(UserRole::class);
	}

	public function hasRole(Int $role_id): Bool {
		return in_array(
			$role_id,
			array_column((array) $this->roles(), 'id')
		);
	}

	public function setPasswordAttribute($password): void {
		$this->attributes['password'] = Hash::make($password);
	}

	public function getProfileAttribute($profile): Profile {
		return Profile::where('user_id', $this->attributes['id'])
			->first();
	}

	public function getRolesAttribute($roles) {
		return UserRole::where('user_id', $this->attributes['id'])
			->get();
	}

	public function checkPassword(string $password): bool {
		return Hash::check($password, $this->attributes['password']);
	}

	public function isActive(): bool {
		return $this->attributes['activated'];
	}
}
