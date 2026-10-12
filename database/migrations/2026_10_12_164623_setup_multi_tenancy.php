<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat Tabel Induk: Sekolah
        if (!Schema::hasTable('sekolah')) {
            Schema::create('sekolah', function (Blueprint $table) {$table->id();
                $table->string('nama_sekolah');$table->string('alamat')->nullable();
                $table->string('logo')->nullable();$table->timestamps();
            });
        }

        // DETEKSI OTOMATIS NAMA TABEL ANDA (Bebas Error Singular/Plural)
        $tabelAnggota = Schema::hasTable('anggota') ? 'anggota' : 'anggotas';$tabelBuku = Schema::hasTable('buku') ? 'buku' : 'bukus';
        $tabelPeminjaman = Schema::hasTable('peminjaman') ? 'peminjaman' : 'peminjamen';$tabelPengaturan = Schema::hasTable('pengaturan') ? 'pengaturan' : 'pengaturans';

        // 2. Tambahkan sekolah_id ke tabel Users
        if (!Schema::hasColumn('users', 'sekolah_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');$table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            });
        }

        // 3. Tambahkan sekolah_id ke tabel Anggota
        if (Schema::hasTable($tabelAnggota) && !Schema::hasColumn($tabelAnggota, 'sekolah_id')) {
            Schema::table($tabelAnggota, function (Blueprint$table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');$table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            });
        }

        // 4. Tambahkan sekolah_id ke tabel Buku
        if (Schema::hasTable($tabelBuku) && !Schema::hasColumn($tabelBuku, 'sekolah_id')) {
            Schema::table($tabelBuku, function (Blueprint$table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');$table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            });
        }

        // 5. Tambahkan sekolah_id ke tabel Peminjaman
        if (Schema::hasTable($tabelPeminjaman) && !Schema::hasColumn($tabelPeminjaman, 'sekolah_id')) {
            Schema::table($tabelPeminjaman, function (Blueprint$table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');$table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            });
        }

        // 6. Tambahkan sekolah_id ke tabel Pengaturan
        if (Schema::hasTable($tabelPengaturan) && !Schema::hasColumn($tabelPengaturan, 'sekolah_id')) {
            Schema::table($tabelPengaturan, function (Blueprint$table) {
                $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');$table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        $tabelAnggota = Schema::hasTable('anggota') ? 'anggota' : 'anggotas';$tabelBuku = Schema::hasTable('buku') ? 'buku' : 'bukus';
        $tabelPeminjaman = Schema::hasTable('peminjaman') ? 'peminjaman' : 'peminjamen';$tabelPengaturan = Schema::hasTable('pengaturan') ? 'pengaturan' : 'pengaturans';

        $tables = [
            'users' => 'users',
            'anggota' => $tabelAnggota,
            'buku' => $tabelBuku,
            'peminjaman' => $tabelPeminjaman,
            'pengaturan' => $tabelPengaturan,
        ];

        foreach ($tables as$table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'sekolah_id')) {
                Schema::table($table, function (Blueprint$table) {
                    $table->dropForeign(['sekolah_id']);$table->dropColumn('sekolah_id');
                });
            }
        }

        Schema::dropIfExists('sekolah');
    }
};
