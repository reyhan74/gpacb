<x-layouts.manage title="Agenda Kegiatan">
    <div class="mb-4"><h3 class="fw-bold text-body mb-1">Agenda Kegiatan</h3><p class="text-body-secondary mb-0">Kegiatan mendatang dan riwayat kegiatan calon anggota.</p></div>
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold mb-3">Kegiatan Mendatang</h5>
        <div class="row g-3">
            @forelse($upcoming as $activity)
                <div class="col-md-6"><div class="border rounded-3 p-3 h-100"><span class="badge text-bg-primary mb-2">{{ $activity->activity_date?->format('d/m/Y') }}</span><h6 class="fw-bold mb-1">{{ $activity->title }}</h6><p class="text-body-secondary small mb-0">{{ $activity->description ?: 'Belum ada keterangan.' }}</p></div></div>
            @empty
                <div class="col-12 text-body-secondary">Belum ada kegiatan mendatang.</div>
            @endforelse
        </div>
    </div>
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-3">Riwayat Kegiatan</h5>
        <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Tanggal</th><th>Judul Kegiatan</th><th>Penjelasan</th><th>Status</th></tr></thead><tbody>
            @forelse($history as $log)
                <tr><td>{{ $log->week_date?->format('d/m/Y') }}</td><td>{{ $log->topic?->title ?: '-' }}</td><td>{{ $log->material ?: '-' }}</td><td><span class="badge text-bg-success">Hadir</span></td></tr>
            @empty
                <tr><td colspan="4" class="text-center text-body-secondary py-4">Belum ada riwayat kegiatan.</td></tr>
            @endforelse
        </tbody></table></div>
    </div>
</x-layouts.manage>