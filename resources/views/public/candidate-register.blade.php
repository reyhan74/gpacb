<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Calon Anggota — GPA</title>
    <link rel="icon" href="{{ $siteLogoUrl }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; color: #0f172a; }
        .register-shell { max-width: 720px; margin: 40px auto; padding: 0 18px; }
        .register-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 22px; box-shadow: 0 18px 45px rgba(15,23,42,.08); }
        .register-logo { width: 88px; height: 88px; }
        .required { color: #dc2626; }
        @media (max-width: 576px) { .register-shell { margin: 20px auto; } .register-logo { width: 76px; height: 76px; } }
    </style>
</head>
<body>
    <main class="register-shell">
        <div class="register-card p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="register-logo d-inline-flex align-items-center justify-content-center rounded-circle bg-white p-1 shadow-sm overflow-hidden mb-3">
                    <img class="w-100 h-100 d-block object-fit-contain rounded-circle" src="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}" alt="Logo GPA">
                </div>
                <h1 class="h3 fw-bold mb-1">Pendaftaran Calon Anggota</h1>
                <p class="text-secondary mb-0">GPA SMK Canda Bhirawa Pare</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('public.candidates.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Nama Lengkap <span class="required">*</span></label><input name="nama" value="{{ old('nama') }}" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Nomor WhatsApp <span class="required">*</span></label><input name="no_hp" value="{{ old('no_hp') }}" class="form-control" inputmode="tel" required></div>
                    <div class="col-md-6"><label class="form-label">Tempat Lahir <span class="required">*</span></label><input name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Tanggal Lahir <span class="required">*</span></label><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Jenis Kelamin <span class="required">*</span></label><select name="jenis_kelamin" class="form-select" required><option value="">Pilih jenis kelamin</option><option value="Laki-Laki" @selected(old('jenis_kelamin') === 'Laki-Laki')>Laki-Laki</option><option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option></select></div>
                    <div class="col-md-6"><label class="form-label">Agama <span class="required">*</span></label><input name="agama" value="{{ old('agama','Islam') }}" class="form-control" required></div>
                    <div class="col-12"><label class="form-label">Alamat <span class="required">*</span></label><textarea name="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea></div>
                    <div class="col-12"><label class="form-label">Motivasi <span class="required">*</span></label><textarea name="motivasi" rows="4" class="form-control" required>{{ old('motivasi') }}</textarea></div>
                    <div class="col-12"><label class="form-label">Email <span class="required">*</span></label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div>
                    <div class="col-12"><div class="form-check"><input type="checkbox" name="consent" value="1" class="form-check-input" id="consent" required><label for="consent" class="form-check-label">Saya bersedia mengikuti pematerian, Diklat Ruang, Diklat SAR, dan proses seleksi GPA. <span class="required">*</span></label></div></div>
                    <div class="col-12"><div class="form-check"><input type="checkbox" name="notification_consent" value="1" class="form-check-input" id="notification_consent" required><label for="notification_consent" class="form-check-label">Saya bersedia menerima notifikasi pendaftaran melalui WhatsApp dan email. <span class="required">*</span></label></div></div>
                </div>
                <button class="btn btn-primary w-100 mt-4 py-2 fw-bold">Kirim Pendaftaran</button>
            </form>
            <div class="text-center mt-3"><a href="{{ route('public.candidates.status') }}" class="small">Cek status pendaftaran</a></div>
        </div>
    </main>
</body>
</html>
