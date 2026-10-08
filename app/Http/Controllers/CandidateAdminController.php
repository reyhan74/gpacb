<?php

namespace App\Http\Controllers;

use App\Models\CandidateRegistration;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $stage = (string) $request->input('stage', '');
        $query = CandidateRegistration::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('registration_code', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }
        if ($stage !== '') {
            $query->where('status', $stage);
        }

        $candidates = $query->latest()->paginate(15)->withQueryString();
        return view('manage.candidates.index', compact('candidates', 'search', 'stage'));
    }

    public function show(CandidateRegistration $candidate)
    {
        return view('manage.candidates.show', compact('candidate'));
    }

    public function stage(Request $request, CandidateRegistration $candidate)
    {
        $data = $request->validate([
            'stage' => ['required', 'in:materi,diklat_ruang,diklat_sar'],
            'result' => ['required', 'in:attended,passed,failed'],
            'date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $stage = $data['stage'];
        $settings = \App\Models\SiteSetting::current();
        $scheduledDate = $stage === 'diklat_ruang' ? $settings->diklat_ruang_schedule : ($stage === 'diklat_sar' ? $settings->diklat_sar_schedule : null);
        if (in_array($stage, ['diklat_ruang', 'diklat_sar'], true) && ! $scheduledDate) {
            return back()->withErrors(['stage' => 'Jadwal '.$stage.' belum ditentukan Superadmin.']);
        }
        if ($scheduledDate && $data['date'] && $data['date'] !== $scheduledDate->toDateString()) {
            return back()->withErrors(['date' => 'Tanggal harus mengikuti jadwal yang ditentukan Superadmin.']);
        }
        $column = $stage.'_status';
        $dateColumn = $stage.'_date';
        if ($scheduledDate) {
            $data['date'] = $scheduledDate->toDateString();
        }
        if ($stage === 'diklat_ruang' && ! in_array($candidate->materi_status, ['attended', 'passed'], true)) {
            return back()->withErrors(['stage' => 'Pematerian harus diikuti sebelum Diklat Ruang.']);
        }
        if ($stage === 'diklat_sar' && ! in_array($candidate->diklat_ruang_status, ['attended', 'passed'], true)) {
            return back()->withErrors(['stage' => 'Diklat Ruang harus diikuti sebelum Diklat SAR.']);
        }

        $candidate->{$column} = $data['result'];
        $candidate->{$dateColumn} = $data['date'] ?: now()->toDateString();
        if ($stage === 'diklat_sar' && in_array($data['result'], ['attended', 'passed'], true)) {
            $candidate->status = 'nia_eligible';
            $candidate->nia_eligible_at = now();
        } elseif ($data['result'] === 'passed') {
            $candidate->status = $stage;
        } else {
            $candidate->status = $stage;
        }
        $candidate->review_notes = $data['notes'] ?? $candidate->review_notes;
        $candidate->reviewed_by = auth()->id();
        $candidate->reviewed_at = now();
        $candidate->save();

        return back()->with('success', 'Tahapan calon berhasil diperbarui.');
    }

    public function reject(Request $request, CandidateRegistration $candidate)
    {
        $data = $request->validate(['rejection_reason' => ['required', 'string', 'max:2000']]);
        $candidate->update(['status' => 'rejected', 'rejection_reason' => $data['rejection_reason'], 'reviewed_by' => auth()->id(), 'reviewed_at' => now()]);
        return redirect()->route('manage.candidates.show', $candidate)->with('success', 'Calon ditandai ditolak.');
    }

    public function issueNia(CandidateRegistration $candidate)
    {
        abort_if($candidate->status !== 'nia_eligible' || ! in_array($candidate->diklat_sar_status, ['attended', 'passed'], true), 422, 'Diklat SAR belum diikuti.');
        abort_if($candidate->approved_member_id, 422, 'NIA sudah diterbitkan.');

        DB::transaction(function () use ($candidate): void {
            $candidate->refresh();
            $nia = $this->nextNia($candidate->angkatan);
            $member = MemberService::importMemberRow([
                'nia' => $nia, 'nama' => $candidate->nama, 'nama_lapangan' => $candidate->nama_lapangan,
                'nis' => $candidate->nis, 'ttl' => trim(($candidate->tempat_lahir ?: '').', '.($candidate->tanggal_lahir?->format('d-m-Y') ?: '')),
                'alamat' => $candidate->alamat, 'no_hp' => $candidate->no_hp, 'jenis_kelamin' => $candidate->jenis_kelamin ?: 'Laki-Laki', 'agama' => $candidate->agama ?: 'Islam',
            ]);
            $candidate->update(['status' => 'member', 'approved_member_id' => $member->id, 'approved_by' => auth()->id(), 'approved_at' => now(), 'nia_issued_at' => now()]);
        });

        return back()->with('success', 'Diklat SAR lulus. NIA berhasil diterbitkan.');
    }

    private function nextNia(string $angkatan): string
    {
        $last = \App\Models\Member::where('nia', 'like', 'GPA.'.$angkatan.'.%')->orderByDesc('id')->value('nia');
        $number = $last && preg_match('/\.(\d+)$/', $last, $m) ? ((int) $m[1]) + 1 : 1;
        return sprintf('GPA.%s.%03d', strtoupper($angkatan), $number);
    }
}
