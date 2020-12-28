<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	public function up(): void {
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('password');
			$table->boolean('activated')->default(false);
			$table->timestamps();
		});
	}

	public function down(): void {
		Schema::dropIfExists('password_resets');
		Schema::dropIfExists('profile');
		Schema::dropIfExists('user_activation');
		Schema::dropIfExists('users');
	}
}
