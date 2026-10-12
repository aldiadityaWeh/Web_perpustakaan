<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;
    use \App\Traits\ScopeSekolah;

    protected $table = 'peminjaman';
    protected $guarded = ['id'];

    // Mendaftarkan kolom virtual otomatis agar terbaca di Blade / JSON
    protected $appends = ['hari_terlambat', 'denda_berjalan', 'status_aktual'];

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

    // 1. Otomatisasi Status
    public function getStatusAktualAttribute()
    {
        // Jika di database statusnya sudah kembali, kunci statusnya!
        if (strtolower(trim($this->status)) === 'dikembalikan' || $this->tanggal_dikembalikan != null) {
            return 'Dikembalikan';
        }

        // Cek keterlambatan menggunakan startOfDay (Jam 00:00:00)
        if ($this->tanggal_jatuh_tempo) {
            $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo)->startOfDay();
            if (Carbon::today()->gt($jatuhTempo)) {
                return 'Terlambat';
            }
        }

        return 'Dipinjam';
    }

    // 2. Otomatisasi Perhitungan Selisih Hari (PASTI BULAT & ANTI MINUS)
    public function getHariTerlambatAttribute()
    {
        if (!$this->tanggal_jatuh_tempo) return 0;

        // Paskan waktu ke jam 00:00 agar perhitungan harinya bulat!
        $jatuhTempo = Carbon::parse($this->tanggal_jatuh_tempo)->startOfDay();

        // JIKA BUKU SUDAH KEMBALI: Hitung selisih telat pada saat tanggal dia mengembalikan
        if ($this->tanggal_dikembalikan) {
            $tglKembali = Carbon::parse($this->tanggal_dikembalikan)->startOfDay();
            if ($tglKembali->gt($jatuhTempo)) {
                return (int) $jatuhTempo->diffInDays($tglKembali);
            }
        }
        // JIKA BUKU BELUM KEMBALI: Hitung selisih telat secara live hari ini
        else {
            $hariIni = Carbon::today();
            if ($hariIni->gt($jatuhTempo)) {
                return (int) $jatuhTempo->diffInDays($hariIni);
            }
        }

        return 0;
    }

    // 3. Otomatisasi Kalkulasi Denda
        public function getDendaBerjalanAttribute()
    {
        // JIKA SUDAH KEMBALI: Tampilkan nominal denda permanen dari database
        if (strtolower(trim($this->status)) === 'dikembalikan' && $this->denda !== null) {
            return (int) $this->denda;
        }

        // JIKA BELUM KEMBALI: Kalkulasi dendanya secara real-time
        $hariTelat = $this->hari_terlambat;

        if ($hariTelat > 0) {
            // AMAN DARI ERROR: Simpan angka (integer) nya saja ke dalam Cache, bukan seluruh object Model
            $dendaPerHari = Cache::remember('nominal_denda_per_hari', 3600, function () {
                // Ambil langsung nilai kolom denda_per_hari (default 1000 jika tabel kosong)
                return \App\Models\Pengaturan::value('denda_per_hari') ?? 1000;
            });

            return $hariTelat * $dendaPerHari;
        }

        return 0;
    }
}
