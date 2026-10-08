<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function index(): View
    {
        return view('manage.dashboard', [
            'newsCount' => Content::query()->where('type', 'berita')->count(),
            'materialCount' => Content::query()->where('type', 'materi')->count(),
        ]);
    }

    public function users(): View
    {
        return view('manage.users', ['users' => User::query()->orderBy('name')->get(), 'documentationAdmins' => User::query()->where('is_documentation_admin', true)->get()]);
    }

    public function documentationAdmin(): View
    {
        abort_unless(auth()->user()->isSuperadmin(), 403);
        return view('manage.documentation-admin', [
            'members' => User::query()->where('role', 'anggota')->orderBy('name')->get(),
        ]);
    }

    public function updateDocumentationAdmin(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        return $this->assignDocumentationAdmin($request);
    }

    
    public function assignDocumentationAdmin(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        abort_unless(auth()->user()->isSuperadmin(), 403);
        $data = $request->validate([
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['integer', 'distinct', 'exists:users,id'],
        ]);
        $added = User::query()->whereIn('id', $data['user_ids'] ?? [])->where('role', 'anggota')->pluck('id');
        abort_if($added->count() !== count($data['user_ids'] ?? []), 422, 'Semua Sie Dokumentasi harus berasal dari anggota.');
        $existing = User::query()->where('is_documentation_admin', true)->where('role', 'anggota')->pluck('id');
        $allDocumentation = $existing->merge($added)->unique()->values();
        User::query()->where('is_documentation_admin', true)->update(['is_documentation_admin' => false]);
        User::query()->whereIn('id', $allDocumentation)->update(['is_documentation_admin' => true]);
        return back()->with('status', 'Anggota Sie Dokumentasi berhasil ditambahkan.');
    }
}
