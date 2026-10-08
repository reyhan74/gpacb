<x-layouts.manage title="Ganti Kata Sandi">
    <div class="mb-4">
        <h4 class="fw-bold text-body tracking-tight mb-1">Keamanan Akun</h4>
        <p class="text-body-secondary fs-7 mb-0">Perbarui kata sandi akun portal anggota Anda untuk menjaga keamanan data pribadi.</p>
    </div>

    @if(auth()->user()->must_change_password)
        <div class="alert alert-warning border-0 rounded-3 mb-4 fs-7">
            <strong>Perhatian:</strong> Ini adalah login pertama Anda. Silakan ganti kata sandi bawaan dengan kata sandi baru pilihan Anda.
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4 fs-7">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4" style="max-width: 520px;">
        <form method="POST" action="{{ route('member.password.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Kata Sandi Saat Ini / Default (NIS) *</label>
                <input type="password" name="current_password" class="form-control" required placeholder="Masukkan kata sandi lama">
            </div>

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Kata Sandi Baru * (Min. 6 Karakter)</label>
                <input type="password" name="password" class="form-control" required placeholder="Buat kata sandi baru">
            </div>

            <div class="mb-4">
                <label class="form-label fs-7 fw-bold">Konfirmasi Kata Sandi Baru *</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi baru">
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold py-2.5">Simpan Kata Sandi Baru</button>
        </form>
    </div>
</x-layouts.manage>
