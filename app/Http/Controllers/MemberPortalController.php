<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\KtaService;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MemberPortalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $member = $user->member ?: Member::where('nia', $user->nia)->first();

        return view('member.dashboard', compact('user', 'member'));
    }

    public function previewKta()
    {
        $user = Auth::user();
        $member = $user->member ?: Member::where('nia', $user->nia)->firstOrFail();

        $photoUrl = null;
        if ($member->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($member->foto)) {
            $photoUrl = '/storage/' . ltrim($member->foto, '/');
        }

        return view('member.kta-preview', compact('user', 'member', 'photoUrl'));
    }

    public function downloadKta()
    {
        $user = Auth::user();
        $member = $user->member ?: Member::where('nia', $user->nia)->firstOrFail();

        $pdf = KtaService::generatePdf($member);

        return $pdf->download('KTA-' . str_replace('.', '-', $member->nia) . '.pdf');
    }

    public function editProfile()
    {
        $user = Auth::user();
        $member = $user->member ?: Member::where('nia', $user->nia)->firstOrFail();

        return view('member.profile', compact('user', 'member'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $member = $user->member ?: Member::where('nia', $user->nia)->firstOrFail();

        $data = $request->validate([
            'no_hp' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }
            $path = ImageCompressionService::store($request->file('foto'), 'members/photos');
            $data['foto'] = $path;
        }

        $member->update($data);

        return back()->with('success', 'Profil dan data kontak Anda berhasil diperbarui!');
    }

    public function changePasswordForm()
    {
        return view('member.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route($user->isCalon() ? 'candidate.dashboard' : 'member.dashboard')->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
