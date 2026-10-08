<?php

namespace App\Http\Controllers;

use App\Models\CandidateRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CandidateRegistrationController extends Controller
{
    public function create()
    {
        return view('public.candidate-register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'agama' => ['required', 'string', 'max:30'],
            'alamat' => ['required', 'string', 'max:1000'],
            'motivasi' => ['required', 'string', 'max:3000'],
            'consent' => ['accepted'],
            'notification_consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Persetujuan proses seleksi wajib dicentang.',
            'notification_consent.accepted' => 'Persetujuan notifikasi wajib dicentang.',
        ]);

        unset($data['consent'], $data['notification_consent']);
        $data['notification_consent_at'] = now();
        $data['registration_code'] = $this->registrationCode();
        $data['status'] = 'registered';
        $data['angkatan'] = 'Belum Ditentukan';
        $data['consent_at'] = now();
        $data['consent_ip'] = $request->ip();

        $candidate = DB::transaction(function () use ($data): CandidateRegistration {
            $candidate = CandidateRegistration::create($data);
            $user = User::create([
                'name' => $candidate->nama,
                'email' => strtolower($candidate->registration_code).'@calon.gpa.local',
                'password' => Hash::make($candidate->no_hp),
                'role' => 'calon',
                'must_change_password' => true,
            ]);
            $candidate->update(['user_id' => $user->id]);
            return $candidate->fresh();
        });

        return redirect()->route('public.candidates.status', ['code' => $candidate->registration_code])
            ->with('initial_login_code', $candidate->registration_code)
            ->with('initial_login_password', $candidate->no_hp)
            ->with('status', 'Pendaftaran calon anggota berhasil dikirim.');
    }

    public function status(Request $request)
    {
        $candidate = null;
        if ($request->filled('code') && $request->filled('no_hp')) {
            $candidate = CandidateRegistration::query()
                ->where('registration_code', strtoupper(trim($request->input('code'))))
                ->where('no_hp', trim($request->input('no_hp')))
                ->first();
        }

        return view('public.candidate-status', compact('candidate'));
    }

    private function registrationCode(): string
    {
        do {
            $code = 'GPA-CALON-'.strtoupper(Str::random(8));
        } while (CandidateRegistration::where('registration_code', $code)->exists());

        return $code;
    }
}
