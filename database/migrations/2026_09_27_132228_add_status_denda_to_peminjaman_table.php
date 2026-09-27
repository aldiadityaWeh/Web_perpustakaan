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
        Schema::table('peminjaman', function (Blueprint $table) {
            // Menambahkan kolom status denda setelah kolom denda
            $table->enum('status_denda', ['Bebas Denda', 'Belum Lunas', 'Lunas'])->default('Bebas Denda')->after('denda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('status_denda');
        });
    }
};
