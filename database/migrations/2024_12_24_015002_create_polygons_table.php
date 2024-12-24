<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('polygons', function (Blueprint $table) {
			$table->id();
			$table->geometry('geom', 4326);
			$table->string('name');
			$table->string('description')->nullable();
			$table->timestamps();
		});

		// Spatial Index
		Schema::table('polygons', function (Blueprint $table) {
			$table->spatialIndex('geom');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('polygons');
	}
};
