<x-layouts.manage title="Data Anggota & NIA">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-body tracking-tight mb-1">Manajemen Data Anggota & NIA</h4>
            <p class="text-body-secondary fs-7 mb-0">Kelola Nomor Induk Anggota resmi, biodata lengkap, ekspor KTA Digital, dan akun login anggota.</p>
        </div>
        <div>
            <a href="{{ route('manage.members.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-3 fs-7 fw-semibold shadow-xs">
                <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
                <span>Tambah Anggota</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('success') }}</div>
    @endif

    {{-- KOTAK IMPORT CSV --}}
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-3 mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i data-lucide="file-spreadsheet" class="text-success" style="width: 18px; height: 18px;"></i>
            <h6 class="fw-bold text-body mb-0 fs-7">Import Data Massal Excel / CSV</h6>
        </div>
        <p class="text-body-secondary fs-8 mb-2">Gunakan template agar nama kolom dan format data sesuai sistem.</p>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="{{ route('manage.members.import-template') }}" class="btn btn-sm btn-outline-primary rounded-3 fw-semibold d-inline-flex align-items-center gap-1">
                <i data-lucide="download" style="width:14px;height:14px;"></i>
                Download Template CSV
            </a>
            <span class="text-body-secondary fs-8">Kolom: <code>nia, nama, nama_lapangan, nis, ttl, alamat, no_hp, jenis_kelamin, agama</code></span>
        </div>
        <form method="POST" action="{{ route('manage.members.import-csv') }}" enctype="multipart/form-data" class="d-flex gap-2 flex-wrap mt-3">
            @csrf
            <input type="file" name="csv_file" accept=".csv,.txt" required class="form-control form-control-sm bg-body border-body-subtle" style="max-width: 320px;">
            <button type="submit" class="btn btn-sm btn-outline-success rounded-3 fw-semibold d-inline-flex align-items-center gap-1">
                <i data-lucide="upload" style="width:14px;height:14px;"></i>
                Unggah File CSV
            </button>
        </form>
    </div>

    {{-- TABEL DATA ANGGOTA BERBENTUK ENTERPRISE CARD --}}
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-body-tertiary border-bottom border-body-subtle py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <form method="GET" action="{{ route('manage.members.index') }}" class="member-filter d-flex gap-2 flex-grow-1 flex-wrap" style="max-width: 720px;">
                <div class="input-group input-group-sm flex-grow-1" style="min-width: 220px;">
                    <span class="input-group-text bg-body border-body-subtle text-body-secondary"><i data-lucide="search" style="width:14px;height:14px;"></i></span>
                    <input type="search" name="search" placeholder="Cari nama, NIA, NIS, HP, TTL..." value="{{ $search }}" class="form-control bg-body border-body-subtle">
                </div>
                <select name="angkatan" class="form-select form-select-sm bg-body border-body-subtle" style="max-width: 170px;">
                    <option value="">Semua Angkatan</option>
                    @foreach($listAngkatan as $ang)
                        <option value="{{ $ang }}" @selected($angkatan === $ang)>Angkatan {{ $ang }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1"><i data-lucide="search" style="width:14px;height:14px;"></i> Cari</button>
                @if($search !== '' || $angkatan !== '')
                    <a href="{{ route('manage.members.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"><i data-lucide="x" style="width:14px;height:14px;"></i> Reset</a>
                @endif
            </form>
            <span class="badge bg-body border border-body-subtle text-body-secondary rounded-pill px-2.5 py-1 fs-8">
                Total: {{ $members->total() }} Anggota
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary fs-8 text-uppercase text-body-secondary border-bottom border-body-subtle">
                    <tr>
                        <th class="ps-4">N.I.A</th>
                        <th>Nama Anggota</th>
                        <th>Nama Rimba</th>
                        <th>Angkatan</th>
                        <th>TTL & Kontak</th>
                        <th>Tipe</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                    <tr>
                        <td class="ps-4 font-monospace fw-bold text-success fs-7">{{ $m->nia }}</td>
                        <td>
                            <div class="fw-bold text-body fs-7">{{ $m->nama }}</div>
                            <small class="text-body-secondary fs-8">NIS: {{ $m->nis ?: '-' }}</small>
                        </td>
                        <td class="text-warning fw-semibold fs-7">"{{ $m->nama_lapangan ?: '-' }}"</td>
                        <td><span class="badge bg-success-subtle text-success">{{ $m->angkatan ?: '-' }}</span></td>
                        <td class="fs-8 text-body-secondary">
                            <div>{{ $m->ttl_raw ?: ($m->tempat_lahir . ', ' . ($m->tanggal_lahir ? $m->tanggal_lahir->format('d/m/Y') : '-')) }}</div>
                            <small>{{ $m->no_hp ?: '-' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-body text-uppercase fs-8">{{ $m->tipe_anggota }}</span>
                        </td>
                        <td class="text-end pe-4 text-nowrap">
                            <a href="{{ route('manage.members.kta', $m) }}" class="btn btn-sm btn-outline-warning py-1 px-2 fs-8 fw-semibold" title="Preview KTA">KTA</a>
                            <a href="{{ route('manage.members.edit', $m) }}" class="btn btn-sm btn-outline-primary py-1 px-2 fs-8 fw-semibold">Edit</a>
                            <form method="POST" action="{{ route('manage.members.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Hapus data anggota {{ $m->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2 fs-8 fw-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data anggota ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
        <div class="card-footer bg-body-tertiary border-top border-body-subtle py-3 px-4">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</x-layouts.manage>
