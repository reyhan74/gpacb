<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\KtaService;
use App\Services\MemberService;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MemberAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $angkatan = $request->input('angkatan', '');

        $query = Member::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nia', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nama_lapangan', 'like', "%{$search}%")
                    ->orWhere('ttl_raw', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($angkatan !== '') {
            $query->where('angkatan', $angkatan);
        }

        $members = $query->latest('id')->paginate(15)->withQueryString();
        $listAngkatan = Member::whereNotNull('angkatan')
            ->where('angkatan', '!=', '')
            ->distinct()
            ->orderBy('angkatan')
            ->pluck('angkatan');

        return view('manage.members.index', compact('members', 'search', 'angkatan', 'listAngkatan'));
    }

    public function create()
    {
        return view('manage.members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nia' => ['required', 'string', 'max:50', 'unique:members,nia'],
            'nama' => ['required', 'string', 'max:255'],
            'nama_lapangan' => ['nullable', 'string', 'max:100'],
            'nis' => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'agama' => ['required', 'string', 'max:50'],
            'tipe_anggota' => ['required', 'in:anggota,pembina,pelatih,alumni'],
            'tanggal_purna' => ['nullable', 'date', 'required_if:tipe_anggota,pembina,pelatih'],
            'angkatan' => [
                'nullable',
                'string',
                'max:30',
                Rule::in(in_array($request->input('tipe_anggota'), ['pembina', 'pelatih', 'alumni'], true)
                    ? array_merge(config('gpa.active_cohorts', []), ['XXIII'])
                    : config('gpa.active_cohorts', [])),
            ],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'pembina_nama' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $data['status_keanggotaan'] = $data['tipe_anggota'] === 'alumni' ? 'Alumni' : 'Aktif';
        if (in_array($data['tipe_anggota'], ['anggota', 'alumni'], true)) {
            $data['tanggal_purna'] = null;
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = ImageCompressionService::store($request->file('foto'), 'members/photos');
        }

        MemberService::importMemberRow($data);

        return redirect()->route('manage.members.index')->with('success', 'Anggota berhasil ditambahkan dan akun login telah dibuat.');
    }

    public function edit(Member $member)
    {
        return view('manage.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nama_lapangan' => ['nullable', 'string', 'max:100'],
            'nis' => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'agama' => ['required', 'string', 'max:50'],
            'tipe_anggota' => ['required', 'in:anggota,pembina,pelatih,alumni'],
            'tanggal_purna' => ['nullable', 'date', 'required_if:tipe_anggota,pembina,pelatih'],
            'angkatan' => [
                'nullable',
                'string',
                'max:30',
                Rule::in(in_array($request->input('tipe_anggota'), ['pembina', 'pelatih', 'alumni'], true)
                    ? array_merge(config('gpa.active_cohorts', []), ['XXIII'])
                    : config('gpa.active_cohorts', [])),
            ],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $data['status_keanggotaan'] = $data['tipe_anggota'] === 'alumni' ? 'Alumni' : 'Aktif';
        if (in_array($data['tipe_anggota'], ['anggota', 'alumni'], true)) {
            $data['tanggal_purna'] = null;
        }

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }
            $data['foto'] = ImageCompressionService::store($request->file('foto'), 'members/photos');
        }

        $member->update($data);

        if ($member->user) {
            $member->user->update(['name' => $member->nama]);
        }

        return redirect()->route('manage.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }

        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();

        return redirect()->route('manage.members.index')->with('success', 'Data anggota dan akun login berhasil dihapus.');
    }

    public function downloadImportTemplate()
    {
        $headers = ['nia', 'nama', 'nama_lapangan', 'nis', 'ttl', 'alamat', 'no_hp', 'jenis_kelamin', 'agama'];
        $example = ['GPA.XXVI.001', 'NAMA LENGKAP ANGGOTA', 'nama rimba', '12345', 'Kediri, 01 Januari 2010', 'Alamat lengkap', '081234567890', 'Laki-Laki', 'Islam'];

        $stream = fopen('php://temp', 'w+');
        fputcsv($stream, $headers);
        fputcsv($stream, $example);
        rewind($stream);
        $csv = stream_get_contents($stream);
        fclose($stream);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template-import-anggota-gpa.csv"',
        ]);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = null;
        $count = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (! $header) {
                $header = array_map(fn($h) => strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h))), $row);
                continue;
            }

            if (empty(array_filter($row))) continue;

            $data = array_combine($header, $row);
            if ($data && !empty($data['nia'])) {
                MemberService::importMemberRow($data);
                $count++;
            }
        }
        fclose($handle);

        return redirect()->route('manage.members.index')->with('success', "Berhasil mengimpor {$count} data anggota dari CSV!");
    }

    public function previewKta(Member $member)
    {
        $photoUrl = null;
        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            $photoUrl = '/storage/' . ltrim($member->foto, '/');
        }

        return view('manage.members.kta-preview', compact('member', 'photoUrl'));
    }

    public function downloadKta(Member $member)
    {
        $pdf = KtaService::generatePdf($member);
        return $pdf->download('KTA-' . str_replace('.', '-', $member->nia) . '.pdf');
    }
}
