<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->date('production_date');
            $table->integer('engine_capacity');
            $table->string('color');
            $table->integer('status');
            $table->boolean('has_turbo');
            $table->boolean('is_new');
            $table->boolean('has_sunroof');
            $table->integer('kilometerage');
            $table->integer('duration');
            $table->integer('price');
            $table->integer('consumption');
            $table->integer('top_speed');
            $table->integer('dimensions');
            $table->timestamps();
            $table->foreignId('fuel_type_id')->constrained();
            $table->foreignId('transmission_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('car_model_id')->constrained();
            $table->foreignId('type_of_shop_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
