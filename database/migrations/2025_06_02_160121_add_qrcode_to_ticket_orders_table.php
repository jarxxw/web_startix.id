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
        Schema::table('ticket_orders', function (Blueprint $table) {
            $table->string('qrcode')->nullable()->unique()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('ticket_orders', function (Blueprint $table) {
    $table->string('qrcode')->nullable()->after('status');
    });
    }
};
