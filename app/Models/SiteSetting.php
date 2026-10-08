<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

#[Fillable([
    'site_name', 'logo_path', 'slideshow_duration', 'school_name', 'instagram_url', 'whatsapp_number', 'whatsapp_group_link', 'diklat_ruang_schedule', 'diklat_sar_schedule', 'email',
    'address', 'supervisor_name', 'about_text', 'contact_info',
])]
class SiteSetting extends Model
{
    public static function current(): self
    {
        $defaults = [
            'site_name' => 'Generasi Pencinta Alam',
            'school_name' => 'SMK Canda Bhirawa Pare',
        ];

        if (! Schema::hasTable('site_settings')) {
            return new static($defaults);
        }

        return static::query()->firstOrCreate([], $defaults);
    }

    protected $casts = [
        'diklat_ruang_schedule' => 'date',
        'diklat_sar_schedule' => 'date',
    ];

    public function whatsappUrl(): ?string
    {
        if (blank($this->whatsapp_number)) {
            return null;
        }

        return 'https://wa.me/'.preg_replace('/\D+/', '', $this->whatsapp_number);
    }
}
