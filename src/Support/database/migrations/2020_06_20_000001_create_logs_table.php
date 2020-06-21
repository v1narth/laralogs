<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
	public function up(): void {
		Schema::create('logs', function (Blueprint $table) {
			$table->increments('id');
			$table->morphs('versionable');
			$table->string('column')->nullable();
			$table->string('previous')->nullable();
			$table->string('current')->nullable();
			$table->bigInteger('group_id')->default(0);
			$table->set('action', ['created', 'updated', 'deleted']);

			$table->timestamp('created_at');
		});
	}
}