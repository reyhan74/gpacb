<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\ImageCompressionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    public function edit(): View
    {
        return view('manage.settings', ['settings' => SiteSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'slideshow_duration' => ['sometimes', 'integer', 'min:3', 'max:60'],
            'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'whatsapp_group_link' => ['nullable', 'url', 'max:255', 'regex:/^https:\/\/chat\.whatsapp\.com\//i'],
            'diklat_ruang_schedule' => ['nullable', 'date'],
            'diklat_sar_schedule' => ['nullable', 'date', 'after_or_equal:diklat_ruang_schedule'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'supervisor_name' => ['nullable', 'string', 'max:255'],
            'about_text' => ['nullable', 'string'],
            'contact_info' => ['nullable', 'string'],
        ]);

        $settings = SiteSetting::current();
        unset($data['logo'], $data['remove_logo']);

        if ($request->hasFile('logo')) {
            $oldLogo = $settings->logo_path;
            $data['logo_path'] = ImageCompressionService::store($request->file('logo'), 'branding');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
        } elseif ($request->boolean('remove_logo') && $settings->logo_path) {
            if (Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $data['logo_path'] = null;
        }

        $settings->update($data);

        return back()->with('status', 'Informasi website berhasil diperbarui.');
    }

    public function logo()
    {
        $settings = SiteSetting::current();
        abort_unless($settings->logo_path && Storage::disk('public')->exists($settings->logo_path), 404);

        return Storage::disk('public')->response($settings->logo_path);
    }
}
