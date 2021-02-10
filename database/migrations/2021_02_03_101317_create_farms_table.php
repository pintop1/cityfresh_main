<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('name');
            $table->string('cover_image');
            $table->datetime('start_date');
            $table->datetime('close_date');
            $table->string('duration');
            $table->string('duration_type');
            $table->string('price_per_unit');
            $table->string('roi');
            $table->string('available_units');
            $table->string('total_units');
            $table->string('status')->default('pending');
            $table->boolean('rollover')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farms');
    }
}
