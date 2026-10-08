<x-layouts.manage title="Kegiatan Mingguan">
<div class="mb-4"><h3 class="fw-bold">Kegiatan Mingguan</h3><p class="text-body-secondary">Pilih kegiatan sesuai tanggal, lalu isi penjelasannya.</p></div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
<div class="card bg-body border-body-subtle rounded-4 p-4"><form method="POST" action="{{ route('candidate.weekly-log.store') }}">@csrf<div class="row g-3"><div class="col-md-6"><label class="form-label">Tanggal Kegiatan *</label><input type="date" name="activity_date" class="form-control" value="{{ old('activity_date', now()->toDateString()) }}" required></div><div class="col-md-6"><label class="form-label">Judul Kegiatan *</label><select name="topic_id" class="form-select" required><option value="">Pilih kegiatan</option>@foreach($topics as $topic)<option value="{{ $topic->id }}" data-activity-date="{{ $topic->activity_date?->format('Y-m-d') }}" @selected(old('topic_id') == $topic->id)>{{ $topic->activity_date?->format('d/m/Y') }} — {{ $topic->title }}</option>@endforeach</select></div><div class="col-12"><label class="form-label">Penjelasan Kegiatan *</label><textarea name="material" rows="5" class="form-control" placeholder="Jelaskan kegiatan yang diikuti..." required>{{ old('material') }}</textarea></div></div><button class="btn btn-success mt-3">Simpan Penjelasan</button></form></div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const date = document.querySelector('[name="activity_date"]');
    const select = document.querySelector('[name="topic_id"]');
    const sync = () => {
        [...select.options].forEach(option => {
            if (!option.value) return;
            option.hidden = option.dataset.activityDate !== date.value;
            option.disabled = option.dataset.activityDate !== date.value;
        });
        if (select.selectedOptions[0]?.disabled) select.value = '';
    };
    date.addEventListener('change', sync);
    sync();
});
</script>
</x-layouts.manage>