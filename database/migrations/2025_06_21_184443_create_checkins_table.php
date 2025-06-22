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
    Schema::create('checkins', function (Blueprint $table) {
        $table->id();

        // Relasi ke tabel events
        $table->foreignId('event_id')
              ->constrained('events')
              ->onDelete('cascade');

        $table->string('name');
        $table->string('identity_number');
        $table->timestamp('jam_checkin')->nullable();
        $table->enum('status', ['valid', 'invalid'])->default('valid');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
