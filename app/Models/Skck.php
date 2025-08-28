<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skck extends Model
{
    use HasFactory;

    protected $table = 'skcks';

    protected $fillable = [
        'nomor_skck',
        'nama_lengkap',
        'kewarganegaraan',
        'nik',
        'passport',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_masuk',
        'alamat',
        'agama',
        'pekerjaan',
        'keperluan',
        'jenis_pembayaran',
        'petugas_id',
        'masa_berlaku',
        'foto_path',
        'tanggal_dibuat'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'masa_berlaku' => 'date',
        'tanggal_dibuat' => 'datetime',
    ];

    // Accessor untuk format tanggal masuk
    public function getTanggalMasukFormattedAttribute()
    {
        return $this->tanggal_masuk->format('d-m-Y');
    }

    // Accessor untuk format masa berlaku
    public function getMasaBerlakuFormattedAttribute()
    {
        return $this->tanggal_dibuat->format('d-m-Y') . ' s/d ' .
            $this->masa_berlaku->format('d-m-Y');
    }

    // Scope untuk data yang masih berlaku
    public function scopeMasihBerlaku($query)
    {
        return $query->where('masa_berlaku', '>=', now());
    }

    // Scope untuk 3 jenis pembayaran
    public function scopeTunai($query)
    {
        return $query->where('jenis_pembayaran', 'tunai');
    }

    public function scopeOnline($query)
    {
        return $query->where('jenis_pembayaran', 'online');
    }

    public function scopeOnlineSudahBayar($query)
    {
        return $query->where('jenis_pembayaran', 'online_sudah_bayar');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        // Convert string dates to Carbon instances
        if (!$startDate instanceof \Carbon\Carbon) {
            $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        }
        if (!$endDate instanceof \Carbon\Carbon) {
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
        }

        // Gunakan tanggal_dibuat instead of created_at
        return $query->whereBetween('tanggal_dibuat', [$startDate, $endDate]);
    }
}
