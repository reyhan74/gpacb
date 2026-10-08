<x-layouts.manage title="Portal Anggota - GPA">
    <div class="mb-4">
        <h3 class="fw-bold text-body tracking-tight mb-1">Portal Data Anggota</h3>
        <p class="text-body-secondary fs-7 mb-0">Selamat datang, <strong>{{ $user->name }}</strong>. Berikut adalah Kartu Tanda Anggota resmi Anda.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('success') }}</div>
    @endif

    <div class="row g-4 mb-4">
        <!-- PREVIEW KTA BERDESAIN RESMI -->
        <div class="col-12 col-lg-7">
            <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fs-8 fw-bold">
                        KARTU TANDA ANGGOTA AKTIF
                    </span>
                    <a href="{{ route('member.kta.preview') }}" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1.5 rounded-3 fs-8 fw-bold shadow-xs">
                        <i data-lucide="eye" style="width: 14px; height: 14px;"></i>
                        <span>Lihat KTA</span>
                    </a>
                </div>

                @if($member)
                <div class="p-4 rounded-4 text-white shadow-sm" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);">
                    <div class="text-center mb-3 border-bottom border-white border-opacity-25 pb-2">
                        <div class="fw-bold fs-7 tracking-wider">KARTU TANDA ANGGOTA</div>
                        <div class="fs-8 text-warning-emphasis">GENERASI PECINTA ALAM SMK CANDA BHIRAWA PARE</div>
                        <small style="font-size:0.65rem; color:#fed7aa;">Jl. Mayjen Mas Isman Tulungrejo • Pare - Kediri</small>
                    </div>

                    <div class="d-flex gap-3 align-items-center flex-wrap">
                        <div class="rounded-3 border border-white border-opacity-50 overflow-hidden" style="width: 76px; height: 100px; background: #581c87; display: grid; place-items: center;">
                            @if($member->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($member->foto))
                                <img src="{{ '/storage/' . ltrim($member->foto, '/') }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <span class="fw-bold fs-8 text-white">FOTO 3x4</span>
                            @endif
                        </div>

                        <div class="flex-grow-1 fs-7">
                            <div class="d-flex justify-content-between py-0.5 border-bottom border-white border-opacity-10">
                                <span class="text-warning-emphasis" style="width: 110px;">Nama</span>
                                <strong class="text-white">{{ strtoupper($member->nama) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-0.5 border-bottom border-white border-opacity-10">
                                <span class="text-warning-emphasis" style="width: 110px;">Nama Lapangan</span>
                                <strong class="text-warning">"{{ $member->nama_lapangan ?: '-' }}"</strong>
                            </div>
                            <div class="d-flex justify-content-between py-0.5 border-bottom border-white border-opacity-10">
                                <span class="text-warning-emphasis" style="width: 110px;">N.I.A.</span>
                                <strong class="font-monospace text-white">{{ $member->nia }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-0.5 border-bottom border-white border-opacity-10">
                                <span class="text-warning-emphasis" style="width: 110px;">NIS</span>
                                <span class="text-white">{{ $member->nis ?: '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-0.5">
                                <span class="text-warning-emphasis" style="width: 110px;">TTL</span>
                                <span class="text-white">{{ $member->ttl_raw ?: ($member->tempat_lahir . ', ' . ($member->tanggal_lahir ? $member->tanggal_lahir->format('d/m/Y') : '-')) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- MENU AKSI PRIBADI ANGGOTA -->
        <div class="col-12 col-lg-5">
            <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="fw-bold text-body mb-2 fs-7">Pengaturan Akun & Kontak Mandiri</h6>
                    <p class="text-body-secondary fs-8 mb-3">
                        Sebagai anggota, Anda dapat memperbarui nomor kontak aktif WhatsApp, alamat domisili, dan foto profil yang tercantum pada KTA.
                    </p>

                    <div class="list-group list-group-flush mb-3">
                        <div class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center fs-8">
                            <span class="text-body-secondary">No. WhatsApp</span>
                            <strong>{{ $member?->no_hp ?: '-' }}</strong>
                        </div>
                        <div class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center fs-8">
                            <span class="text-body-secondary">Angkatan</span>
                            <span class="badge bg-success-subtle text-success">{{ $member?->angkatan ?: '-' }}</span>
                        </div>
                        <div class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-center fs-8">
                            <span class="text-body-secondary">Alamat</span>
                            <span class="text-truncate text-body" style="max-width: 180px;">{{ $member?->alamat ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('member.profile') }}" class="btn btn-outline-success flex-grow-1 rounded-3 fs-8 fw-semibold py-2">
                        Ubah Kontak & Foto
                    </a>
                    <a href="{{ route('member.password.change') }}" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold py-2">
                        Ganti Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.manage>
