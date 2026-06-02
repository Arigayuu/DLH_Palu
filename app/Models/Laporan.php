<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'nomor_tiket',
        'nomor_hp',
        'kategori',
        'deskripsi',
        'latitude',
        'longitude',
        'status',
        'alasan_penolakan',
        'bukti_foto_selesai',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_tiket)) {
                do {
                    $code = 'DLH-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
                } while (static::where('nomor_tiket', $code)->exists());
                $model->nomor_tiket = $code;
            }
        });
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(LaporanFoto::class, 'laporan_id');
    }
}
