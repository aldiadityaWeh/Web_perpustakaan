<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->string('kepala_sekolah')->nullable()->after('alamat_sekolah');
            $table->string('nip_kepala_sekolah', 50)->nullable()->after('kepala_sekolah');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->dropColumn(['kepala_sekolah', 'nip_kepala_sekolah']);
        });
    }
};
