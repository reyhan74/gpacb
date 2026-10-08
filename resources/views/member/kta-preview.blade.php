<x-layouts.manage title="Kartu Tanda Anggota (KTA)">
    <div class="mb-4">
        <h3 class="fw-bold text-body tracking-tight mb-1">Kartu Tanda Anggota (KTA) Digital</h3>
        <p class="text-body-secondary fs-7 mb-0">Preview KTA resmi Anda. Unduh PDF atau cetak langsung dari halaman ini.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('success') }}</div>
    @endif

    {{-- TOMBOL AKSI --}}
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('member.kta.download') }}" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-3 fs-7 fw-bold shadow-sm">
            <i data-lucide="download" style="width:16px;height:16px;"></i>
            Unduh KTA PDF
        </a>
        <button onclick="window.print()" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 rounded-3 fs-7">
            <i data-lucide="printer" style="width:16px;height:16px;"></i>
            Cetak Langsung
        </button>
        <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 rounded-3 fs-7">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
            Kembali
        </a>
    </div>

    {{-- KTA PREVIEW --}}
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-3 p-md-4 mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i data-lucide="id-card" class="text-success" style="width:20px;height:20px;"></i>
            <h6 class="fw-bold text-body mb-0 fs-7">Preview KTA — Responsif Mengikuti Layar</h6>
        </div>

        <style>
            .kta-wrap {
                width: 100%;
                max-width: 100%;
            }
            .kta-card {
                width: 100%;
                aspect-ratio: 85.6 / 53.98;
                background: #ffffff;
                border-radius: clamp(4px, 1.2vw, 10px);
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0,0,0,0.10), 0 1px 4px rgba(0,0,0,0.06);
                border: 1px solid #d1d5db;
                display: flex;
                flex-direction: column;
                font-family: 'Helvetica Neue', Arial, sans-serif;
            }
            /* HEADER — ~20% tinggi */
            .kta-card .kh {
                background: linear-gradient(135deg, #d95a1b 0%, #b8410e 100%);
                flex: 0 0 20%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 1.5% 3%;
                color: #fff;
                text-align: center;
                gap: 0;
            }
            .kta-card .kh-t { font-size: clamp(10px, 2.2vw, 18px); font-weight: 800; letter-spacing: 0.12em; line-height: 1.2; }
            .kta-card .kh-o { font-size: clamp(7px, 1.5vw, 12px); color: #fde0c8; font-weight: 600; margin-top: 1px; }
            .kta-card .kh-a { font-size: clamp(5px, 1.1vw, 9px); color: #f9c9a0; margin-top: 1px; }

            /* BODY — ~58% tinggi */
            .kta-card .kb {
                flex: 1 1 auto;
                display: flex;
                gap: 2.5%;
                padding: 2.5% 3%;
                min-height: 0;
            }
            /* Foto — proporsional 3:4 */
            .kta-card .kf {
                flex: 0 0 22%;
                aspect-ratio: 3 / 4;
                border-radius: clamp(3px, 0.8vw, 6px);
                overflow: hidden;
                border: 1.5px solid #c0c6cf;
                background: #581c87;
                display: grid;
                place-items: center;
                align-self: flex-start;
            }
            .kta-card .kf img { width: 100%; height: 100%; object-fit: cover; display: block; }
            .kta-card .kf .kf-ph { color: #fff; font-size: clamp(6px, 1.2vw, 11px); font-weight: 700; text-align: center; line-height: 1.3; }

            /* Data tabel */
            .kta-card .kd {
                flex: 1;
                min-width: 0;
                display: flex;
                align-items: center;
            }
            .kta-card .kd table {
                width: 100%;
                border-collapse: collapse;
                font-size: clamp(7px, 1.5vw, 13px);
                line-height: 1.5;
            }
            .kta-card .kd td { padding: clamp(0px, 0.3vw, 2px) clamp(1px, 0.4vw, 3px); vertical-align: top; }
            .kta-card .kd .l { width: 32%; color: #475569; font-weight: 600; white-space: nowrap; }
            .kta-card .kd .s { width: 4%; text-align: center; color: #94a3b8; }
            .kta-card .kd .v { color: #0f172a; font-weight: 600; word-break: break-word; }

            /* Footer pengesahan — ~22% tinggi */
            .kta-card .kft {
                flex: 0 0 22%;
                display: flex;
                justify-content: flex-end;
                align-items: flex-end;
                padding: 0 3% 2.5%;
            }
            .kta-card .ks {
                text-align: center;
                font-size: clamp(5px, 1.1vw, 9px);
                color: #475569;
                line-height: 1.4;
            }
            .kta-card .ks .sn {
                font-weight: 700;
                text-decoration: underline;
                color: #0f172a;
                margin-top: clamp(6px, 2vw, 20px);
            }

            /* PRINT: ukuran asli CR80 */
            @media print {
                body * { visibility: hidden; }
                .kta-card, .kta-card * { visibility: visible; }
                .kta-card {
                    position: fixed; left: 0; top: 0;
                    width: 85.6mm !important; height: 53.98mm !important;
                    aspect-ratio: auto;
                    box-shadow: none; border: none; border-radius: 0;
                }
                @page { size: 85.6mm 53.98mm; margin: 0; }
            }
        </style>

        <div class="kta-wrap">
            <div class="kta-card">
                {{-- HEADER --}}
                <div class="kh">
                    <div class="kh-t">KARTU TANDA ANGGOTA</div>
                    <div class="kh-o">GENERASI PECINTA ALAM SMK CANDA BHIRAWA PARE</div>
                    <div class="kh-a">Jl. Mayjen Mas Isman Tulungrejo &bull; smkcbpare.sch.id &bull; Pare - Kediri</div>
                </div>

                {{-- BODY: FOTO + DATA --}}
                <div class="kb">
                    <div class="kf">
                        @if($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Foto {{ $member->nama }}">
                        @else
                            <span class="kf-ph">FOTO<br>3×4</span>
                        @endif
                    </div>
                    <div class="kd">
                        <table>
                            <tr><td class="l">Nama</td><td class="s">:</td><td class="v">{{ strtoupper($member->nama) }}</td></tr>
                            <tr><td class="l">Nama Lapangan</td><td class="s">:</td><td class="v" style="color:#c2410c; font-style:italic;">"{{ $member->nama_lapangan ?: '-' }}"</td></tr>
                            <tr><td class="l">N.I.A.</td><td class="s">:</td><td class="v" style="color:#1e3a8a; font-weight:800; font-family:monospace;">{{ $member->nia }}</td></tr>
                            <tr><td class="l">NIS</td><td class="s">:</td><td class="v">{{ $member->nis ?: '-' }}</td></tr>
                            <tr><td class="l">TTL</td><td class="s">:</td><td class="v">{{ $member->ttl_raw ?: ($member->tempat_lahir . ', ' . ($member->tanggal_lahir ? $member->tanggal_lahir->translatedFormat('d F Y') : '-')) }}</td></tr>
                            <tr><td class="l">Jenis Kelamin</td><td class="s">:</td><td class="v">{{ $member->jenis_kelamin }}</td></tr>
                            <tr><td class="l">No. HP</td><td class="s">:</td><td class="v">{{ $member->no_hp ?: '-' }}</td></tr>
                            <tr><td class="l">Agama</td><td class="s">:</td><td class="v">{{ $member->agama }}</td></tr>
                            <tr><td class="l">Alamat</td><td class="s">:</td><td class="v">{{ $member->alamat ?: '-' }}</td></tr>
                        </table>
                    </div>
                </div>

                {{-- FOOTER PENGESAHAN --}}
                <div class="kft">
                    <div class="ks">
                        <div>Pare, {{ ($member->tanggal_pengesahan ?? now())->translatedFormat('d F Y') }}</div>
                        <div>{{ $member->pembina_jabatan ?: 'Pembina GPA SMK CB' }}</div>
                        <div class="sn">{{ $member->pembina_nama ?: 'RICKY HIDAYAT, S.Pd' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <span class="badge bg-body-tertiary text-body-secondary border border-body-subtle rounded-pill px-3 py-1 fs-8">
                Rasio kartu CR80 (8,56 × 5,398 cm) — otomatis menyesuaikan ukuran layar
            </span>
        </div>
    </div>

    {{-- INFO --}}
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4">
        <div class="d-flex align-items-start gap-3">
            <i data-lucide="info" class="text-primary flex-shrink-0 mt-1" style="width:18px;height:18px;"></i>
            <div class="fs-8 text-body-secondary">
                <strong class="text-body">Catatan:</strong>
                KTA ditampilkan dengan rasio asli kartu ID CR80 (8,56 × 5,398 cm) dan otomatis menyesuaikan ukuran layar perangkat Anda. Gunakan <strong>Unduh KTA PDF</strong> untuk file cetak ukuran asli, atau <strong>Cetak Langsung</strong> untuk print dari browser. Pastikan foto 3×4 sudah diunggah via <a href="{{ route('member.profile') }}" class="text-success fw-semibold">Ubah Data & Kontak</a>.
            </div>
        </div>
    </div>
</x-layouts.manage>
