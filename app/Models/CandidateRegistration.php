<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id', 'registration_code', 'nama', 'nama_lapangan', 'nis', 'email', 'no_hp',
    'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'alamat',
    'angkatan', 'motivasi', 'kontak_darurat', 'foto', 'status',
    'materi_status', 'diklat_ruang_status', 'diklat_sar_status',
    'materi_date', 'diklat_ruang_date', 'diklat_sar_date', 'consent_at', 'consent_ip', 'notification_consent_at',
])]
class CandidateRegistration extends Model
{
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'materi_date' => 'date',
            'diklat_ruang_date' => 'date',
            'diklat_sar_date' => 'date',
            'consent_at' => 'datetime',
            'notification_consent_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'approved_at' => 'datetime',
            'nia_eligible_at' => 'datetime',
            'nia_issued_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function weeklyLogs(): HasMany
    {
        return $this->hasMany(CandidateWeeklyLog::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approvedMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'approved_member_id');
    }
}
