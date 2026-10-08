<x-layouts.manage title="Portal Calon Anggota">
<div class="mb-4"><h3 class="fw-bold text-body mb-1">Portal Calon Anggota</h3><p class="text-body-secondary mb-0">Pilih tanggal kegiatan dan judul materi mingguan.</p></div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<div class="row g-3 mb-4"><div class="col-md-6"><div class="card bg-primary-subtle border-0 rounded-4 p-3"><div class="small">Jadwal Diklat Ruang</div><strong>{{ $settings->diklat_ruang_schedule?->translatedFormat('d F Y') ?: 'Belum ditentukan' }}</strong></div></div><div class="col-md-6"><div class="card bg-info-subtle border-0 rounded-4 p-3"><div class="small">Jadwal Diklat SAR</div><strong>{{ $settings->diklat_sar_schedule?->translatedFormat('d F Y') ?: 'Belum ditentukan' }}</strong></div></div></div>
<div class="row g-4"><div class="col-lg-5"><div class="card bg-body border-body-subtle rounded-4 p-4"><h5 class="fw-bold">{{ $candidate->nama }}</h5><p class="text-body-secondary">Kode: <code>{{ $candidate->registration_code }}</code></p><div class="mb-2">Pematerian <span class="badge text-bg-secondary float-end">{{ $candidate->materi_status }}</span></div><div class="mb-2">Diklat Ruang <span class="badge text-bg-secondary float-end">{{ $candidate->diklat_ruang_status }}</span></div><div>Diklat SAR <span class="badge text-bg-secondary float-end">{{ $candidate->diklat_sar_status }}</span></div></div></div><div class="col-lg-7"><div class="card bg-body border-body-subtle rounded-4 p-4"><h5 class="fw-bold mb-3">Isi Penjelasan Kegiatan</h5><form method="POST" action="{{ route('candidate.weekly-log.store') }}">@csrf<div class="row g-3"><div class="col-md-6"><label class="form-label">Tanggal Kegiatan *</label><input type="date" name="activity_date" class="form-control" value="{{ old('activity_date', now()->toDateString()) }}" required></div><div class="col-md-6"><label class="form-label">Judul Kegiatan *</label><select name="topic_id" class="form-select" required><option value="">Pilih kegiatan</option>@foreach($topics as $topic)<option value="{{ $topic->id }}" data-activity-date="{{ $topic->activity_date?->format('Y-m-d') }}">{{ $topic->activity_date?->format('d/m/Y') }} — {{ $topic->title }}</option>@endforeach</select></div><div class="col-12"><label class="form-label">Penjelasan Kegiatan *</label><textarea name="material" rows="4" class="form-control" required>{{ old('material') }}</textarea></div></div><button class="btn btn-success w-100 mt-3">Simpan Penjelasan</button></form></div></div></div>
<div class="card bg-body border-body-subtle rounded-4 p-4 mt-4"><h5 class="fw-bold">Riwayat Kegiatan</h5><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Tanggal</th><th>Judul Kegiatan</th><th>Penjelasan</th><th>Absensi</th></tr></thead><tbody>@forelse($logs as $log)<tr><td>{{ $log->week_date->format('d/m/Y') }}</td><td>{{ $log->topic?->title ?: '-' }}</td><td>{{ $log->material ?: '-' }}</td><td><span class="badge text-bg-success">Hadir</span></td></tr>@empty<tr><td colspan="4" class="text-center text-body-secondary py-4">Belum ada kegiatan.</td></tr>@endforelse</tbody></table></div>{{ $logs->links() }}</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const date = document.querySelector('[name="activity_date"]');
    const select = document.querySelector('[name="topic_id"]');
    if (!date || !select) return;
    const sync = () => {
        [...select.options].forEach(option => {
            if (!option.value) return;
            const match = option.dataset.activityDate === date.value;
            option.hidden = !match;
            option.disabled = !match;
        });
        if (select.selectedOptions[0]?.disabled) select.value = '';
    };
    date.addEventListener('change', sync);
    sync();
});
</script>
</x-layouts.manage>