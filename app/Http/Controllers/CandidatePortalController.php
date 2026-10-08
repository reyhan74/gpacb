<?php

namespace App\Http\Controllers;

use App\Models\CandidateWeeklyLog;
use App\Models\CandidateWeeklyTopic;
use App\Models\SiteSetting;
use App\Services\ImageCompressionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidatePortalController extends Controller
{
    public function dashboard(): View
    {
        $candidate = auth()->user()->candidateRegistration;
        abort_unless($candidate, 404);
        $logs = $candidate->weeklyLogs()->with('topic')->latest('week_date')->paginate(8);
        $topics = CandidateWeeklyTopic::query()->where('is_active', true)->orderBy('week_number')->get();
        $settings = SiteSetting::current();
        return view('candidate.dashboard', compact('candidate', 'logs', 'topics', 'settings'));
    }

    public function profile(): View
    {
        $candidate = auth()->user()->candidateRegistration;
        abort_unless($candidate, 404);
        return view('candidate.profile', compact('candidate'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $candidate = auth()->user()->candidateRegistration;
        abort_unless($candidate, 404);
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);
        if ($request->hasFile('foto')) {
            if ($candidate->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($candidate->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($candidate->foto);
            }
            $data['foto'] = ImageCompressionService::store($request->file('foto'), 'candidates/photos');
        }
        $candidate->update($data);
        $candidate->user?->update(['name' => $candidate->nama]);
        return back()->with('success', 'Profil calon anggota berhasil diperbarui.');
    }

    public function weeklyLog(): View
    {
        $candidate = auth()->user()->candidateRegistration;
        abort_unless($candidate, 404);
        $topics = CandidateWeeklyTopic::query()->where('is_active', true)->orderBy('week_number')->get();
        return view('candidate.weekly-log', compact('candidate', 'topics'));
    }

    public function agenda(): View
    {
        $candidate = auth()->user()->candidateRegistration;
        abort_unless($candidate, 404);
        $today = now()->toDateString();
        $upcoming = CandidateWeeklyTopic::query()
            ->where('is_active', true)
            ->whereDate('activity_date', '>=', $today)
            ->orderBy('activity_date')
            ->orderBy('week_number')
            ->get();
        $history = $candidate->weeklyLogs()->with('topic')->latest('week_date')->get();
        return view('candidate.agenda', compact('candidate', 'upcoming', 'history'));
    }

    public function storeLog(Request $request): RedirectResponse
    {
        $candidate = auth()->user()->candidateRegistration;
        abort_unless($candidate, 404);
        $data = $request->validate([
            'topic_id' => ['required', 'exists:candidate_weekly_topics,id'],
            'activity_date' => ['required', 'date'],
            'material' => ['required', 'string', 'max:3000'],
        ]);
        $topic = CandidateWeeklyTopic::query()->whereKey($data['topic_id'])->where('is_active', true)->firstOrFail();
        if (! $topic->activity_date || $data['activity_date'] !== $topic->activity_date->toDateString()) {
            return back()->withErrors(['activity_date' => 'Tanggal tidak sesuai dengan jadwal kegiatan yang dipilih.'])->withInput();
        }
        $data['week_date'] = $data['activity_date'];
        $data['activity_type'] = 'materi';
        unset($data['activity_date']);
        $candidate->weeklyLogs()->updateOrCreate(
            ['week_date' => $data['week_date']],
            $data + ['attended' => true, 'submitted_at' => now()]
        );
        return back()->with('success', 'Penjelasan kegiatan dan absensi berhasil disimpan.');
    }
}
