<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\ImageCompressionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('manage.contents.index', ['contents' => Content::query()->with('user.member')->latest()->get()]);
    }

    public function memberIndex(): View
    {
        return view('member.contents.index', ['contents' => auth()->user()->contents()->latest()->get()]);
    }

    public function memberCreate(): View
    {
        return view('member.contents.create');
    }

    public function memberStore(Request $request): RedirectResponse
    {
        $response = $this->store($request);
        return redirect()->route('member.contents.index')->with('status', 'Artikel/kegiatan berhasil dikirim.');
    }

    public function create(): View
    {
        return view('manage.contents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $path = $request->file('attachment')
            ? ($request->file('attachment')->isValid() && str_starts_with((string) $request->file('attachment')->getMimeType(), 'image/')
                ? ImageCompressionService::store($request->file('attachment'), 'uploads')
                : $request->file('attachment')->store('uploads', 'public'))
            : null;

        $request->user()->contents()->create([
            'type' => $data['type'],
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
            'attachment_path' => $path,
            'approval_status' => $request->user()->isAdmin() ? 'approved' : 'pending',
            'approved_by' => $request->user()->isAdmin() ? $request->user()->id : null,
            'approved_at' => $request->user()->isAdmin() ? now() : null,
        ]);

        return redirect()->route('manage.contents.index')->with('status', 'Konten berhasil disimpan.');
    }

    public function approve(Content $content): RedirectResponse
    {
        abort_unless(auth()->user()->isSuperadmin() || auth()->user()->is_documentation_admin, 403);
        $content->update(['approval_status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);
        return back()->with('status', 'Artikel/kegiatan berhasil disetujui.');
    }

    public function edit(Content $content): View
    {
        return view('manage.contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('attachment')) {
            if ($content->attachment_path) {
                Storage::disk('public')->delete($content->attachment_path);
            }
            $data['attachment_path'] = str_starts_with((string) $request->file('attachment')->getMimeType(), 'image/')
                ? ImageCompressionService::store($request->file('attachment'), 'uploads')
                : $request->file('attachment')->store('uploads', 'public');
        }

        $content->update([
            'type' => $data['type'],
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
            'attachment_path' => $data['attachment_path'] ?? $content->attachment_path,
        ]);

        return redirect()->route('manage.contents.index')->with('status', 'Konten berhasil diperbarui.');
    }

    public function destroy(Content $content): RedirectResponse
    {
        if ($content->attachment_path) {
            Storage::disk('public')->delete($content->attachment_path);
        }

        $content->delete();

        return redirect()->route('manage.contents.index')->with('status', 'Konten berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'type' => ['required', 'in:berita,materi'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf', 'max:10240'],
        ];
    }
}
