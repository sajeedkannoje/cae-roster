<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('revision', 10)->nullable();
            $table->string('duty_code', 10)->nullable();
            $table->time('check_in_utc')->nullable();
            $table->time('check_out_utc')->nullable();
            $table->string('activity', 50)->default("UNK");
            $table->string('remark', 255)->nullable();
            $table->string('from', 50);
            $table->time('std_utc')->nullable();
            $table->string('to', 50);
            $table->time('sta_utc')->nullable();
            $table->string('hotel', 50)->nullable();
            $table->time('blh')->nullable();
            $table->time('flight_time')->nullable();
            $table->time('night_time')->nullable();
            $table->time('duration')->nullable();
            $table->string('ext', 10)->nullable();
            $table->integer('pax_booked')->nullable();
            $table->string('ac_registration', 20)->nullable();
            $table->integer('crew_id')->nullable();
            $table->boolean('is_imported')->default(false);
            // we can manage with relation
            //$table->foreign('crew_id')->references('id')->on('crews');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
