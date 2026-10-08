<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CandidateRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginInput = trim($data['email']);
        $candidate = CandidateRegistration::where('registration_code', strtoupper($loginInput))
            ->where('no_hp', $data['password'])
            ->first();
        $user = $candidate?->user ?: User::query()
            ->where('email', $loginInput)
            ->orWhere('email', $loginInput.'@gpa.local')
            ->orWhere('email', strtolower($loginInput).'@calon.gpa.local')
            ->orWhere('nia', $loginInput)
            ->orWhere('name', $loginInput)
            ->first();

        if ($user === null || ! Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Nomor NIA, email, atau kata sandi tidak sesuai.'])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($user->must_change_password) {
            return redirect()->route('member.password.change');
        }

        if ($user->isCalon()) {
            return redirect()->route('member.password.change');
        }

        if ($user->isAnggota()) {
            return redirect()->intended(route('member.dashboard'));
        }

        return redirect()->intended(route('manage.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
