<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration {
	public function up() {
		Schema::create('profiles', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedBigInteger('user_id');
			$table->string('location')->nullable();
			$table->string('steam')->nullable();
			$table->string('epic_games')->nullable();
			$table->string('avatar')->nullable();
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});
	}

	public function down() {
		Schema::dropIfExists('profiles');
	}
}
