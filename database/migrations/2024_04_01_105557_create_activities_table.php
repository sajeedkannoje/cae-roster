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
            $table->string('date');
            $table->time('check_in_utc')->nullable()->comment("Check-in Time");
            $table->time('check_out_utc')->nullable()->comment("Check-out Time");
            $table->string('activity', 50)->default("UNK");
            $table->string('remark', 255)->nullable();
            $table->string('from', 50);
            $table->time('std_utc')->nullable()->comment("Scheduled Time of Departure");
            $table->string('to', 50);
            $table->time('sta_utc')->nullable()->comment("Scheduled Time of Arrival");
            $table->string('hotel', 50)->nullable();
            $table->string('blh')->nullable();
            $table->string('night_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('pax_booked')->nullable();
            $table->string('ac_registration', 20)->nullable();
            $table->integer('crew_id')->nullable();
            $table->boolean('is_imported')->default(false);
            $table->date('activity_date');
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
