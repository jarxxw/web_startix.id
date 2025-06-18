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
            $table->string('name');
            $table->string('identity_number');
            $table->enum('tipe_ticket', ['reguler', 'vip']);
            $table->timestamp('jam_checkin')->nullable(); // otomatis saat scan, bisa null dulu
            $table->enum('status', ['valid', 'invalid'])->default('valid');
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('checkins');
    // }
};
