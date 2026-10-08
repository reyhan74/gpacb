<x-layouts.manage title="Dashboard Superadmin - GPA">
    <div class="mb-4">
        <h3 class="fw-bold text-body tracking-tight mb-1">Dashboard Pengurus & Superadmin</h3>
        <p class="text-body-secondary fs-7 mb-0">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>. Pantau metrik data anggota dan artikel kegiatan.</p>
    </div>

    <!-- METRIK KARTU DASHBOARD ALUR BILING APP -->
    <div class="row g-3 g-lg-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card p-3 p-lg-4 h-100 d-flex flex-column justify-content-between shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-body-secondary fs-8 fw-bold text-uppercase">Total Anggota</span>
                        <h3 class="fs-2 fw-bold text-body mb-0 mt-1">{{ \App\Models\Member::where('tipe_anggota', 'anggota')->count() }}</h3>
                    </div>
                    <div class="p-2.5 rounded-3 bg-success-subtle text-success">
                        <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between pt-2 border-top border-body-subtle fs-8">
                    <span class="text-body-secondary">Siswa Terdaftar</span>
                    <a href="{{ route('manage.members.index') }}" class="text-success fw-bold text-decoration-none">Kelola &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card p-3 p-lg-4 h-100 d-flex flex-column justify-content-between shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-body-secondary fs-8 fw-bold text-uppercase">Angkatan Terdata</span>
                        <h3 class="fs-2 fw-bold text-primary mb-0 mt-1">{{ \App\Models\Member::whereNotNull('angkatan')->distinct('angkatan')->count('angkatan') }}</h3>
                    </div>
                    <div class="p-2.5 rounded-3 bg-primary-subtle text-primary">
                        <i data-lucide="layers" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between pt-2 border-top border-body-subtle fs-8">
                    <span class="text-body-secondary">Generasi GPA</span>
                    <span class="badge bg-primary-subtle text-primary">XXIII - XXV</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card p-3 p-lg-4 h-100 d-flex flex-column justify-content-between shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-body-secondary fs-8 fw-bold text-uppercase">Artikel & Rilis</span>
                        <h3 class="fs-2 fw-bold text-warning mb-0 mt-1">{{ \App\Models\Content::count() }}</h3>
                    </div>
                    <div class="p-2.5 rounded-3 bg-warning-subtle text-warning">
                        <i data-lucide="newspaper" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between pt-2 border-top border-body-subtle fs-8">
                    <span class="text-body-secondary">Publikasi Website</span>
                    <a href="{{ route('manage.contents.index') }}" class="text-warning fw-bold text-decoration-none">Lihat &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="dash-card p-3 p-lg-4 h-100 d-flex flex-column justify-content-between shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-body-secondary fs-8 fw-bold text-uppercase">KTA Digital</span>
                        <h3 class="fs-2 fw-bold text-info mb-0 mt-1">Aktif</h3>
                    </div>
                    <div class="p-2.5 rounded-3 bg-info-subtle text-info">
                        <i data-lucide="id-card" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between pt-2 border-top border-body-subtle fs-8">
                    <span class="text-body-secondary">Format CR80 PDF</span>
                    <span class="badge bg-info-subtle text-info">Otomatis</span>
                </div>
            </div>
        </div>
    </div>

    <!-- AKSI CEPAT DAN RINGKASAN ANGGOTA TERBARU -->
    <div class="row g-3 g-lg-4">
        <div class="col-12 col-lg-8">
            <div class="card bg-body border-body-subtle shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-body-tertiary border-bottom border-body-subtle py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-body mb-0 fs-7 d-flex align-items-center gap-2">
                        <i data-lucide="users" class="text-success" style="width: 18px; height: 18px;"></i>
                        <span>Anggota Baru Terdaftar</span>
                    </h6>
                    <a href="{{ route('manage.members.index') }}" class="fs-8 text-success fw-bold text-decoration-none">Semua Anggota &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-body-tertiary fs-8 text-uppercase text-body-secondary">
                            <tr>
                                <th class="ps-4">N.I.A</th>
                                <th>Nama Lengkap</th>
                                <th>Nama Rimba</th>
                                <th>Angkatan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Member::latest('id')->take(5)->get() as $mem)
                            <tr>
                                <td class="ps-4 font-monospace fw-bold text-success fs-7">{{ $mem->nia }}</td>
                                <td class="fw-bold fs-7">{{ $mem->nama }}</td>
                                <td class="text-warning fw-semibold fs-7">"{{ $mem->nama_lapangan ?: '-' }}"</td>
                                <td><span class="badge bg-success-subtle text-success">{{ $mem->angkatan ?: '-' }}</span></td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('manage.members.kta', $mem) }}" class="btn btn-sm btn-outline-success py-1 px-2 fs-8 fw-semibold">Unduh KTA</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada anggota terdaftar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4 h-100">
                <h6 class="fw-bold text-body mb-3 fs-7">Aksi Cepat Pengurus</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('manage.members.create') }}" class="btn btn-success d-flex align-items-center justify-content-center gap-2 rounded-3 fs-7 fw-semibold py-2.5">
                        <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
                        <span>Input Anggota Baru</span>
                    </a>
                    <a href="{{ route('manage.contents.create') }}" class="btn btn-outline-success d-flex align-items-center justify-content-center gap-2 rounded-3 fs-7 fw-semibold py-2.5">
                        <i data-lucide="pen-line" style="width: 16px; height: 16px;"></i>
                        <span>Buat Artikel / Rilis Kegiatan</span>
                    </a>
                    <a href="{{ route('manage.settings.edit') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2 rounded-3 fs-7 fw-semibold py-2.5">
                        <i data-lucide="settings" style="width: 16px; height: 16px;"></i>
                        <span>Pengaturan Nama & Web</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.manage>
