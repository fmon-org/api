<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration {
	public function up(): void {
		Schema::create('password_resets', function (Blueprint $table) {
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
	public function down(): void {
		Schema::dropIfExists('password_resets');
	}
}
