<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai dengan migration Anda (peminjamen)
    protected $table = 'peminjaman';
    protected $guarded = [];

    // --- RELASI DATABASE ---
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    // --- ACCESSOR: LOGIKA CERDAS PERHITUNGAN OTOMATIS ---

    // 1. Otomatisasi Status (Cek apakah terlambat)
    public function getStatusAktualAttribute()
    {
        $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo)->endOfDay();
        if (strtolower(trim($this->status)) === 'dipinjam' && Carbon::now()->gt($jatuhTempo)) {
            return 'Terlambat';
        }
        return $this->status;
    }

    // 2. Otomatisasi Perhitungan Selisih Hari
    public function getHariTerlambatAttribute()
    {
        if ($this->status_aktual === 'Terlambat') {
            $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo)->endOfDay();
            return Carbon::now()->diffInDays($jatuhTempo);
        }
        return 0;
    }

    // 3. Otomatisasi Kalkulasi Denda (Terhubung ke Pengaturan)
    public function getDendaBerjalanAttribute()
    {
        if ($this->hari_terlambat > 0) {
            // Gunakan Cache (selama 1 jam) agar sistem tidak query ke tabel pengaturan berulang kali saat melooping data
            $pengaturan = Cache::remember('pengaturan_sistem', 3600, function () {
                return Pengaturan::first() ?? new Pengaturan(['denda_per_hari' => 1000]);
            });

            return $this->hari_terlambat * $pengaturan->denda_per_hari;
        }
        return 0;
    }
}
