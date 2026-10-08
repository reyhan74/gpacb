<x-layouts.manage title="Profil Calon Anggota">
    <div class="mb-4"><h3 class="fw-bold text-body mb-1">Profil Calon Anggota</h3><p class="text-body-secondary mb-0">Perbarui nama, nomor WhatsApp, dan foto profil.</p></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4" style="max-width:650px"><form method="POST" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
        <div class="mb-3"><label class="form-label fw-semibold">Nama Lengkap *</label><input name="nama" value="{{ old('nama', $candidate->nama) }}" class="form-control" required></div>
        <div class="mb-3"><label class="form-label fw-semibold">Nomor WhatsApp *</label><input name="no_hp" value="{{ old('no_hp', $candidate->no_hp) }}" class="form-control" inputmode="tel" required></div>
        <div class="mb-4"><label class="form-label fw-semibold">Foto Profil</label><input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG, atau WebP. Maksimal 3 MB.</div>@if($candidate->foto)<img src="{{ asset('storage/'.$candidate->foto) }}" class="rounded-circle object-fit-contain mt-3" style="width:90px;height:90px" alt="Foto profil">@endif</div>
        <div class="d-flex justify-content-end gap-2"><a href="{{ route('candidate.dashboard') }}" class="btn btn-outline-secondary">Batal</a><button class="btn btn-success fw-bold">Simpan Profil</button></div>
    </form></div>
</x-layouts.manage>
