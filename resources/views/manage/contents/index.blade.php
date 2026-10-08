<x-layouts.manage title="Artikel & Kegiatan">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-body tracking-tight mb-1">Konten Artikel & Kegiatan</h4>
            <p class="text-body-secondary fs-7 mb-0">Kelola seluruh artikel berita, catatan ekspedisi, dan materi kegiatan organisasi.</p>
        </div>
        <a href="{{ route('manage.contents.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-3 fs-7 fw-semibold shadow-xs">
            <i data-lucide="pen-line" style="width: 16px; height: 16px;"></i>
            <span>Tulis Artikel Baru</span>
        </a>
    </div>

    @if(session('status'))
        <div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('status') }}</div>
    @endif

    <div class="card bg-body border-body-subtle shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary fs-8 text-uppercase text-body-secondary border-bottom border-body-subtle">
                    <tr>
                        <th class="ps-4">Tipe</th>
                        <th>Judul</th>
                        <th>Pengunggah</th>
                        <th>Isi</th>
                        <th>Foto / Lampiran</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $content)
                    <tr>
                        <td class="ps-4"><span class="badge bg-success-subtle text-success text-capitalize">{{ $content->type }}</span></td>
                        <td class="fw-bold text-body fs-7">{{ $content->title }}</td>
                        <td class="text-body-secondary fs-8">{{ $content->user?->member?->nia ?: ($content->user?->nia ?: '-') }}</td>
                        <td class="text-body-secondary fs-8" style="max-width: 300px;">{{ \Illuminate\Support\Str::limit(strip_tags($content->body), 80) }}</td>
                        <td>
                            @if($content->attachment_path)
                                @php($extension = strtolower(pathinfo($content->attachment_path, PATHINFO_EXTENSION)))
                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                                    <a href="{{ '/storage/' . ltrim($content->attachment_path, '/') }}" target="_blank">
                                        <img src="{{ '/storage/' . ltrim($content->attachment_path, '/') }}" alt="{{ $content->title }}" class="rounded-2 border border-body-subtle" style="width:72px;height:48px;object-fit:cover;">
                                    </a>
                                @else
                                    <a href="{{ '/storage/' . ltrim($content->attachment_path, '/') }}" target="_blank" class="btn btn-sm btn-outline-success fs-8 fw-semibold">Buka File</a>
                                @endif
                            @else
                                <span class="text-body-secondary fs-8">—</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 text-nowrap">
                            @if($content->approval_status === 'pending' && (auth()->user()->isSuperadmin() || auth()->user()->is_documentation_admin))
                                <form method="POST" action="{{ route('manage.contents.approve', $content) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success fs-8 fw-semibold">Approve</button></form>
                            @endif
                            <a href="{{ route('manage.contents.edit', $content) }}" class="btn btn-sm btn-outline-primary fs-8 fw-semibold">Edit</a>
                            <form method="POST" action="{{ route('manage.contents.destroy', $content) }}" class="d-inline" onsubmit="return confirm('Hapus konten {{ $content->title }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger fs-8 fw-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada konten artikel atau materi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.manage>
