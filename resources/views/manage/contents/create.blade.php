<x-layouts.manage title="Tulis Artikel Baru">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-body tracking-tight mb-1">Tulis Artikel / Materi Baru</h4>
            <p class="text-body-secondary fs-7 mb-0">Unggah berita kegiatan, catatan ekspedisi, atau materi pendidikan dasar.</p>
        </div>
        <a href="{{ route('manage.contents.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
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
        <form method="POST" action="{{ route('manage.contents.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Jenis Konten *</label>
                    <select name="type" class="form-select" required>
                        <option value="berita" @selected(old('type') === 'berita')>Berita / Artikel</option>
                        <option value="materi" @selected(old('type') === 'materi')>Materi Pendidikan</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fs-7 fw-bold">Judul Artikel *</label>
                    <input name="title" type="text" class="form-control" value="{{ old('title') }}" required placeholder="Judul artikel atau materi">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Isi / Deskripsi *</label>
                <textarea name="body" class="form-control" rows="8" placeholder="Tulis isi artikel atau materi di sini...">{{ old('body') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fs-7 fw-bold">Lampiran (Gambar / File, maks. 10 MB)</label>
                <input name="attachment" type="file" class="form-control">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('manage.contents.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success fw-bold">Simpan & Publikasikan</button>
            </div>
        </form>
    </div>
</x-layouts.manage>
