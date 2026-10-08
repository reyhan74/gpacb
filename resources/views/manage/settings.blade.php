<x-layouts.manage title="Pengaturan Website">
    <div class="mb-4">
        <h4 class="fw-bold text-body tracking-tight mb-1">Pengaturan Website</h4>
        <p class="text-body-secondary fs-7 mb-0">Atur informasi identitas, kontak, dan media sosial yang tampil di website utama GPA.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success border-0 rounded-3 mb-4 fs-7">{{ session('status') }}</div>
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

    <div class="card bg-body border-body-subtle shadow-sm rounded-4 p-4" style="max-width: 800px;">
        <form method="POST" action="{{ route('manage.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h6 class="fw-bold text-body mb-3 d-flex align-items-center gap-2 fs-7">
                <i data-lucide="building" class="text-success" style="width: 16px; height: 16px;"></i>
                Identitas Website
            </h6>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Nama Website *</label>
                    <input name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Logo Website</label>
                    <input name="logo" type="file" accept=".jpg,.jpeg,.png,.webp,.svg" class="form-control" onchange="previewLogo(this)">
                    <div class="form-text">JPG, PNG, WebP, SVG. Maksimal 2 MB.</div>
                    @if($settings->logo_path)
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <img id="logo-preview" src="{{ asset('storage/'.$settings->logo_path) }}" alt="Logo aktif" style="width:58px;height:58px;object-fit:contain;border:1px solid var(--bs-border-color);border-radius:10px;padding:4px;">
                            <label class="form-check mb-0"><input type="checkbox" name="remove_logo" value="1" class="form-check-input"> Hapus logo aktif</label>
                        </div>
                    @else
                        <img id="logo-preview" alt="Preview logo" class="d-none mt-2" style="width:58px;height:58px;object-fit:contain;border:1px solid var(--bs-border-color);border-radius:10px;padding:4px;">
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Nama Sekolah</label>
                    <input name="school_name" class="form-control" value="{{ old('school_name', $settings->school_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Nama Pembina</label>
                    <input name="supervisor_name" class="form-control" value="{{ old('supervisor_name', $settings->supervisor_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Alamat</label>
                    <input name="address" class="form-control" value="{{ old('address', $settings->address) }}">
                </div>
            </div>

            <h6 class="fw-bold text-body mb-3 d-flex align-items-center gap-2 fs-7">
                <i data-lucide="share-2" class="text-primary" style="width: 16px; height: 16px;"></i>
                Kontak & Media Sosial
            </h6>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">URL Instagram</label>
                    <input name="instagram_url" type="url" class="form-control" placeholder="https://instagram.com/..." value="{{ old('instagram_url', $settings->instagram_url) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Nomor WhatsApp</label>
                    <input name="whatsapp_number" type="tel" class="form-control" placeholder="6281234567890" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-bold">Email</label>
                    <input name="email" type="email" class="form-control" value="{{ old('email', $settings->email) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fs-7 fw-bold">Link Grup WhatsApp Calon Anggota</label>
                    <input name="whatsapp_group_link" type="url" class="form-control" placeholder="https://chat.whatsapp.com/..." value="{{ old('whatsapp_group_link', $settings->whatsapp_group_link) }}">
                    <div class="form-text">Link ini tampil setelah pendaftaran calon anggota berhasil.</div>
                </div>
            </div>

            <h6 class="fw-bold text-body mb-3 d-flex align-items-center gap-2 fs-7">
                <i data-lucide="calendar-days" class="text-info" style="width: 16px; height: 16px;"></i>
                Jadwal Pendidikan
            </h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Tanggal Diklat Ruang</label>
                    <input name="diklat_ruang_schedule" type="date" class="form-control" value="{{ old('diklat_ruang_schedule', $settings->diklat_ruang_schedule?->format('Y-m-d')) }}">
                    <div class="form-text">Ditentukan Superadmin. Tampil di portal calon.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-bold">Tanggal Diklat SAR</label>
                    <input name="diklat_sar_schedule" type="date" class="form-control" value="{{ old('diklat_sar_schedule', $settings->diklat_sar_schedule?->format('Y-m-d')) }}">
                    <div class="form-text">Harus sama atau setelah Diklat Ruang.</div>
                </div>
            </div>

            <h6 class="fw-bold text-body mb-3 d-flex align-items-center gap-2 fs-7">
                <i data-lucide="info" class="text-warning" style="width: 16px; height: 16px;"></i>
                Informasi Tambahan
            </h6>

            <div class="mb-3">
                <label class="form-label fs-7 fw-bold">Tentang Website / Organisasi</label>
                <textarea name="about_text" class="form-control" rows="4">{{ old('about_text', $settings->about_text) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fs-7 fw-bold">Informasi Kontak Tambahan</label>
                <textarea name="contact_info" class="form-control" rows="3">{{ old('contact_info', $settings->contact_info) }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success fw-bold">
                    <i data-lucide="save" style="width: 16px; height: 16px; margin-right: 4px;"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewLogo(input) {
            const preview = document.getElementById('logo-preview');
            const file = input.files?.[0];
            if (!preview || !file) return;
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        }
    </script>
</x-layouts.manage>
