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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->datetime('date');
            $table->unsignedInteger('soak_temperature');
            $table->unsignedInteger('soak_time'); //Seconds
            $table->unsignedInteger('reflow_gradient');
            $table->unsignedInteger('ramp_up_gradient');
            $table->unsignedInteger('reflow_peak_temp');
            $table->unsignedInteger('reflow_max_time');
            $table->integer('cooldown_gradient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
