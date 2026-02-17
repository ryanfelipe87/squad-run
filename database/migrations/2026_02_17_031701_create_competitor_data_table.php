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
        Schema::create('competitor_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_competitor')->references('id')->on('competitors');
            $table->float('total_km');
            $table->bigInteger('total_runs');
            $table->time('best_time');
            $table->json('awards_winner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitor_data');
    }
};
