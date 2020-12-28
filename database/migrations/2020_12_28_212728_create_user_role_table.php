<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration {
	public function up(): void {
		Schema::create('user_role', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedInteger('role_id')->default(1);
			$table->unsignedBigInteger('creator_id');
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('creator_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onDelete('cascade');

			$table->unique(['user_id', 'role_id']);
		});
	}

	public function down(): void {
		Schema::dropIfExists('user_role');
	}
}
