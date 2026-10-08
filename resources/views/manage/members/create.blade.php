<x-layouts.manage title="Tambah Anggota Baru">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-body tracking-tight mb-1">Tambah Anggota Baru</h4>
            <p class="text-body-secondary fs-7 mb-0">Input data anggota dan sistem otomatis men-generate akun portal anggota.</p>
        </div>
        <a href="{{ route('manage.members.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4 fs-7">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4" style="max-width: 800px;">
        <form method="POST" action="{{ route('manage.members.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Nomor Induk Anggota (NIA) *</label>
                    <input type="text" name="nia" class="form-control" placeholder="Contoh: GPA.XXIV.025" value="{{ old('nia') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" class="form-control" placeholder="Contoh: 31282" value="{{ old('nis') }}">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label fs-7 fw-bold">Nama Lengkap Siswa *</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama lengkap siswa" value="{{ old('nama') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Nama Lapangan (Rimba)</label>
                    <input type="text" name="nama_lapangan" class="form-control" placeholder="Contoh: bangkep" value="{{ old('nama_lapangan') }}">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Kediri" value="{{ old('tempat_lahir') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="Laki-Laki" @selected(old('jenis_kelamin') === 'Laki-Laki')>Laki-Laki</option>
                        <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Agama *</label>
                    <input type="text" name="agama" class="form-control" value="{{ old('agama', 'Islam') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Tipe Anggota *</label>
                    <select name="tipe_anggota" class="form-select">
                        @foreach(['anggota' => 'Anggota', 'pembina' => 'Pembina', 'pelatih' => 'Pelatih', 'alumni' => 'Alumni'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('tipe_anggota', 'anggota') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Masa Purna Pelatih/Pembina</label>
                    <input type="date" name="tanggal_purna" class="form-control" value="{{ old('tanggal_purna') }}">
                    <div class="form-text">Wajib untuk pelatih/pembina. Diatur manual.</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Angkatan (Romawi)</label>
                    <select name="angkatan" class="form-select"><option value="">Pilih angkatan</option><option value="XXIII" @selected(old('angkatan') === 'XXIII')>XXIII (manual)</option>@foreach(config('gpa.active_cohorts') as $cohort)<option value="{{ $cohort }}" @selected(old('angkatan') === $cohort)>{{ $cohort }}</option>@endforeach</select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Nomor WhatsApp / HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="0856-xxxx-xxxx" value="{{ old('no_hp') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Foto Profil (3x4)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fs-7 fw-bold">Alamat Domisili</label>
                <textarea name="alamat" class="form-control" rows="2" placeholder="Ds. ..., Kec. ..., Kab. Kediri">{{ old('alamat') }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('manage.members.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success fw-bold">Simpan & Buat Akun Anggota</button>
            </div>
        </form>
    </div>
</x-layouts.manage>
