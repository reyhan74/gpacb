<x-layouts.manage title="Sie Dokumentasi">
    <div class="mb-4">
        <h4 class="fw-bold text-body mb-1">Sie Dokumentasi</h4>
        <p class="text-body-secondary fs-7 mb-0">Tambahkan anggota ke Sie Dokumentasi melalui tabel.</p>
    </div>

    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <form method="POST" action="{{ route('manage.documentation-admin.update') }}">
        @csrf
        <div class="card bg-body border-body-subtle rounded-4 overflow-hidden">
            <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center p-3">
                <div><h6 class="fw-bold mb-1">Daftar Anggota</h6><small class="text-body-secondary">Centang anggota yang ditetapkan sebagai Sie Dokumentasi.</small></div>
                <button class="btn btn-success">Tambah / Simpan Plotting</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th class="ps-4" style="width:60px">Pilih</th><th>Nama</th><th>NIA</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td class="ps-4"><input type="checkbox" name="user_ids[]" value="{{ $member->id }}" class="form-check-input" @checked($member->is_documentation_admin)></td>
                            <td class="fw-semibold">{{ $member->name }}</td>
                            <td>{{ $member->nia ?: '-' }}</td>
                            <td>@if($member->is_documentation_admin)<span class="badge text-bg-success">Sie Dokumentasi</span>@else<span class="badge text-bg-secondary">Anggota</span>@endif</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-body-secondary py-4">Belum ada data anggota.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</x-layouts.manage>