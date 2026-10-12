<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeSekolah
{
    protected static function bootScopeSekolah()
    {
        // 1. FILTER OTOMATIS: Hanya tampilkan data milik sekolah admin yang sedang login
        if (auth()->check() && auth()->user()->sekolah_id) {
            static::addGlobalScope('sekolah_id', function (Builder $builder) {
                $builder->where('sekolah_id', auth()->user()->sekolah_id);
            });
        }

        // 2. INPUT OTOMATIS: Saat admin menambah data, otomatis tempelkan ID sekolahnya
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->sekolah_id) {
                $model->sekolah_id = auth()->user()->sekolah_id;
            }
        });
    }
}
