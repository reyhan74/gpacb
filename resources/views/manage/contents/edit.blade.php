<x-layouts.manage title="Edit Artikel / Kegiatan">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-body tracking-tight mb-1">Edit Artikel / Kegiatan</h4>
            <p class="text-body-secondary fs-7 mb-0">Perbarui isi publikasi dan foto dokumentasi kegiatan.</p>
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
        <form method="POST" action="{{ route('manage.contents.update', $content) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Jenis Konten *</label>
                    <select name="type" class="form-select" required>
                        <option value="berita" @selected(old('type', $content->type) === 'berita')>Berita / Artikel</option>
                        <option value="materi" @selected(old('type', $content->type) === 'materi')>Materi Pendidikan</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fs-7 fw-bold">Judul Artikel *</label>
                    <input name="title" type="text" class="form-control" value="{{ old('title', $content->title) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Isi / Deskripsi</label>
                <textarea name="body" class="form-control" rows="8">{{ old('body', $content->body) }}</textarea>
            </div>

            @if($content->attachment_path)
                <div class="mb-3 p-3 rounded-3 bg-body-tertiary border border-body-subtle">
                    <div class="text-body-secondary fs-8 mb-2">File saat ini:</div>
                    @if(in_array(strtolower(pathinfo($content->attachment_path, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif']))
                        <img src="{{ '/storage/' . ltrim($content->attachment_path, '/') }}" alt="{{ $content->title }}" class="rounded-3" style="max-width:260px;max-height:160px;object-fit:cover;">
                    @endif
                    <div class="mt-2"><a href="{{ '/storage/' . ltrim($content->attachment_path, '/') }}" target="_blank" class="fs-8">Buka file</a></div>
                </div>
            @endif

            <div class="mb-4">
                <label class="form-label fs-7 fw-bold">Ganti Foto / Lampiran</label>
                <input name="attachment" type="file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif,application/pdf">
                <div class="form-text">Kosongkan jika tidak ingin mengganti file. Maksimal 10 MB.</div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('manage.contents.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success fw-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-layouts.manage>
