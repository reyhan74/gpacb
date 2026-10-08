<x-layouts.manage title="Ubah Profil Anggota">
    <div class="mb-4">
        <h4 class="fw-bold text-body tracking-tight mb-1">Ubah Profil & Kontak</h4>
        <p class="text-body-secondary fs-7 mb-0">Perbarui nomor WhatsApp aktif, alamat domisili, atau pas foto profil 3x4 Anda.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('success') }}</div>
    @endif

    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4" style="max-width: 650px;">
        <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Nomor WhatsApp / HP Aktif</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $member->no_hp) }}" placeholder="0856-xxxx-xxxx">
            </div>

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Alamat Domisili Tempat Tinggal</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $member->alamat) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fs-7 fw-bold">Pas Foto Profil 3x4 (Tercantum pada KTA Digital)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success fw-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-layouts.manage>
