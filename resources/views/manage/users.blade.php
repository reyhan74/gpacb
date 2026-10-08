<x-layouts.manage title="Akun Pengguna">
    <div class="mb-4">
        <h4 class="fw-bold text-body tracking-tight mb-1">Akun Pengguna Pengelola</h4>
        <p class="text-body-secondary fs-7 mb-0">Daftar akun pengguna sistem yang memiliki akses ke panel administrasi GPA.</p>
    </div>

    @if(session('status'))<div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger border-0 rounded-3 mb-4 fs-7">{{ $errors->first() }}</div>@endif
    <div class="card bg-body border-body-subtle shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary fs-8 text-uppercase text-body-secondary border-bottom border-body-subtle">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Email / NIA</th>
                        <th>Role</th>
                        <th class="text-end pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, #166534, #15803d); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="fw-bold text-body fs-7">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-body-secondary fs-7">{{ $user->email }}</td>
                        <td><span class="badge bg-success-subtle text-success text-capitalize">{{ $user->role }}</span></td>
                        <td class="text-end pe-4"><span class="badge bg-info-subtle text-info">Aktif</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.manage>
