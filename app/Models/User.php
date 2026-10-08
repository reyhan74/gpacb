<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'nia', 'password', 'role', 'must_change_password', 'is_documentation_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    public function isCalon(): bool
    {
        return $this->role === 'calon';
    }

    public function candidateRegistration()
    {
        return $this->hasOne(CandidateRegistration::class);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['superadmin', 'admin'], true);
    }

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_documentation_admin' => 'boolean',
        ];
    }
}
