<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            // Identitas Perpustakaan
            $table->string('nama_sekolah')->default('SDN 6 Cisereuh');
            $table->text('alamat_sekolah')->nullable();
            $table->string('kepala_perpustakaan')->nullable();
            $table->string('nip_kepala')->nullable();

            // Regulasi Peminjaman
            $table->integer('denda_per_hari')->default(1000); // Rp 1.000 per hari
            $table->integer('maksimal_hari_pinjam')->default(7); // 7 Hari standar
            $table->integer('maksimal_buku_pinjam')->default(3); // Maksimal pinjam 3 buku
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
