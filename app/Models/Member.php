<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nia',
        'nama',
        'nama_lapangan',
        'nis',
        'tempat_lahir',
        'tanggal_lahir',
        'ttl_raw',
        'jenis_kelamin',
        'agama',
        'angkatan',
        'tahun_angkatan',
        'tipe_anggota',
        'status_keanggotaan',
        'tanggal_purna',
        'no_hp',
        'alamat',
        'foto',
        'pembina_nama',
        'pembina_jabatan',
        'tanggal_pengesahan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pengesahan' => 'date',
        'tanggal_purna' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
