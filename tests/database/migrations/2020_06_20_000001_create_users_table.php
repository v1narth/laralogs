<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	public function up(): void {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('password')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::drop('users');
	}
}