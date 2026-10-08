<!doctype html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Status Pendaftaran — GPA</title><link rel="icon" href="{{ $siteLogoUrl }}"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
    <main class="container" style="max-width:720px;margin:40px auto 50px"><div class="card border-0 shadow-sm rounded-4 p-4 p-md-5"><h1 class="h4 fw-bold">Status Pendaftaran</h1><p class="text-secondary">Gunakan kode pendaftaran dan nomor WhatsApp untuk melihat perkembangan pendaftaran.</p>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
            @if(session('initial_login_code'))
                <div class="alert alert-warning"><strong>Akun calon anggota dibuat.</strong><br>Login: <code>{{ session('initial_login_code') }}</code><br>Password awal: <code>{{ session('initial_login_password') }}</code><br><small>Wajib ganti password setelah login pertama.</small><br><a href="{{ route('login') }}" class="btn btn-dark btn-sm mt-2">Login Calon Anggota</a></div>
            @endif
            @if($siteSettings->whatsapp_group_link)
                <div class="text-center border rounded-3 p-3 mb-4"><p class="mb-2 fw-semibold">Bergabung ke Grup WhatsApp Calon Anggota</p><a href="{{ $siteSettings->whatsapp_group_link }}" target="_blank" rel="noopener" class="btn btn-success">Gabung Grup WhatsApp</a></div>
            @endif
        @endif
        <form method="GET" action="{{ route('public.candidates.status') }}" class="row g-2 mb-4"><div class="col-md-6"><input name="code" value="{{ request('code') }}" class="form-control" placeholder="GPA-CALON-XXXXXXXX" required></div><div class="col-md-6"><input name="no_hp" value="{{ request('no_hp') }}" class="form-control" placeholder="Nomor WhatsApp" required></div><div class="col-12"><button class="btn btn-primary">Cek Status</button></div></form>
        @if(request()->filled('code') && request()->filled('no_hp'))
            @if($candidate)<div class="alert alert-info"><strong>{{ $candidate->nama }}</strong><br>Kode: <code>{{ $candidate->registration_code }}</code><br>Status: <strong>{{ ucfirst(str_replace('_',' ',$candidate->status)) }}</strong><hr><div>1. Pendaftaran: selesai</div><div>2. Pematerian: {{ ucfirst(str_replace('_',' ',$candidate->materi_status)) }}</div><div>3. Diklat Ruang: {{ ucfirst(str_replace('_',' ',$candidate->diklat_ruang_status)) }}</div><div>4. Diklat SAR: {{ ucfirst(str_replace('_',' ',$candidate->diklat_sar_status)) }}</div>@if($candidate->nia_issued_at)<div class="mt-2">NIA: <strong>Terbit setelah verifikasi</strong></div>@endif</div>@else<div class="alert alert-warning">Data tidak ditemukan. Periksa kode dan nomor WhatsApp.</div>@endif
        @endif
        <a href="{{ route('public.candidates.create') }}">Kembali ke pendaftaran</a>
    </div></main>
</body></html>
