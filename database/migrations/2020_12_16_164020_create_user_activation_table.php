<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivationTable extends Migration {
	public function up() {
		Schema::create('user_activation', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedBigInteger('user_id');
			$table->string('token')->unique();
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});
	}

	public function down() {
		Schema::dropIfExists('user_activation');
	}
}
