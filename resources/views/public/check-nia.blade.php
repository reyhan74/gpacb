<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Nomor Induk Anggota (NIA) — GPA</title>
    <script>
        (function(){
            const t = localStorage.getItem('gpa-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root { --green: #176b45; --green-dark: #104b30; --paper: #f8fafc; --ink: #0f172a; --muted: #64748b; --border: #e2e8f0; --orange: #ea580c; --font: 'Plus Jakarta Sans', -apple-system, sans-serif; }
        [data-theme="dark"] { --paper: #090d16; --ink: #f8fafc; --muted: #94a3b8; --border: #334155; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font); background: var(--paper); color: var(--ink); line-height: 1.6; -webkit-font-smoothing: antialiased; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @media (prefers-reduced-motion: reduce) { *, ::before, ::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; transform: none !important; } }

        /* Navbar */
        .pub-navbar { position: sticky; top: 0; z-index: 1000; padding: 0 2rem; height: 72px; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); animation: slideDown 0.5s ease; }
        [data-theme="dark"] .pub-navbar { background: rgba(15,23,42,0.92); }
        .pub-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--green-dark); font-weight: 800; font-size: 1.1rem; }
        [data-theme="dark"] .pub-brand { color: #4ade80; }
        .pub-brand-icon { width: 38px; height: 38px; flex: 0 0 38px; border-radius: 50%; background: #fff; padding: 2px; display: grid; place-items: center; box-shadow: 0 2px 8px rgba(15,23,42,.18); overflow: hidden; box-sizing: border-box; }.pub-brand-icon img { width: 100%; height: 100%; object-fit: contain; display: block; border-radius: 50%; }
        .pub-nav-links { display: flex; align-items: center; gap: 2rem; list-style: none; }
        .pub-nav-links a { text-decoration: none; color: var(--muted); font-weight: 600; font-size: 0.9rem; transition: color 0.2s; }
        .pub-nav-links a:hover { color: var(--green); }
        .pub-nav-links .btn-login { background: var(--orange); color: #fff; padding: 8px 20px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; transition: all 0.2s; }
        .pub-nav-links .btn-login:hover { background: #c2410c; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(234,88,12,0.3); }
        .mobile-toggle { display: none; background: none; border: 1px solid var(--border); border-radius: 8px; padding: 6px 8px; cursor: pointer; color: var(--ink); }
        @media (max-width: 768px) {
            .pub-navbar { padding: 0 1rem; }
            .pub-nav-links { display: none; position: fixed; top: 72px; left: 0; right: 0; background: var(--paper); flex-direction: column; padding: 1.5rem; gap: 1rem; border-bottom: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
            .pub-nav-links.open { display: flex; }
            .mobile-toggle { display: block; }
        }

        /* Page header */
        .page-header { background: linear-gradient(135deg, #104b30 0%, #176b45 100%); color: #fff; padding: 6rem 2rem 3rem; text-align: center; }
        .page-header h1 { font-size: 2rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 0.5rem; animation: fadeInUp 0.6s ease; }
        .page-header p { color: #bbf7d0; font-size: 1rem; max-width: 600px; margin: 0 auto; animation: fadeInUp 0.6s ease 0.15s both; }

        /* Content */
        .container { max-width: 720px; margin: -2rem auto 4rem; padding: 0 1.5rem; position: relative; z-index: 2; }
        .nia-card {
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 16px 40px -8px rgba(0,0,0,0.08);
            animation: fadeInUp 0.6s ease 0.2s both;
        }
        [data-theme="dark"] .nia-card { background: #111827; border-color: #334155; box-shadow: 0 16px 40px -8px rgba(0,0,0,0.3); }

        .nia-card .input-field {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-family: var(--font);
            font-size: 1rem;
            background: var(--paper);
            color: var(--ink);
            margin-bottom: 1rem;
            transition: all 0.2s;
        }
        [data-theme="dark"] .nia-card .input-field { background: #0f172a; border-color: #334155; color: #f8fafc; }
        .nia-card .input-field:focus { outline: none; border-color: var(--green); box-shadow: 0 0 0 4px rgba(22,101,52,0.15); transform: translateY(-1px); }

        .btn-check-nia {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #104b30, #176b45);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: var(--font);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-check-nia:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,75,48,0.3); }
        .btn-check-nia:active { transform: scale(0.97); }

        .result-box {
            margin-top: 2rem;
            padding: 1.8rem;
            border-radius: 16px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            animation: fadeInUp 0.4s ease;
        }
        [data-theme="dark"] .result-box { background: rgba(34,197,94,0.08); border-color: rgba(34,197,94,0.2); }
        .result-header { display: flex; align-items: center; gap: 8px; color: #166534; font-weight: 800; font-size: 0.9rem; margin-bottom: 1.2rem; }
        [data-theme="dark"] .result-header { color: #4ade80; }

        .result-table { width: 100%; border-collapse: collapse; }
        .result-table td { padding: 8px 0; font-size: 0.9rem; vertical-align: top; }
        .result-table td:first-child { width: 140px; color: var(--muted); font-weight: 600; }
        .result-table td:last-child { font-weight: 700; color: var(--ink); }

        .result-not-found {
            margin-top: 2rem;
            padding: 1.8rem;
            border-radius: 16px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            text-align: center;
            animation: fadeInUp 0.4s ease;
        }
        [data-theme="dark"] .result-not-found { background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.2); color: #fca5a5; }

        .status-badge { display: inline-block; background: #dcfce7; color: #15803d; padding: 3px 10px; border-radius: 6px; font-weight: 800; font-size: 0.78rem; }

        /* Footer */
        .pub-footer { background: #0f172a; color: #94a3b8; padding: 3rem 2rem; text-align: center; font-size: 0.85rem; }
        .pub-footer strong { color: #fff; display: block; font-size: 1rem; margin-bottom: 0.3rem; }
    </style>
</head>
<body>
    @include('public.partials.navbar')

    <div class="page-header">
        <h1>Verifikasi Nomor Induk Anggota</h1>
        <p>Periksa keabsahan status keanggotaan resmi GPA SMK Canda Bhirawa Pare.</p>
    </div>

    <main class="container">
        <div class="nia-card">
            <form method="GET" action="{{ route('public.check-nia') }}">
                <input type="text" name="q" placeholder="Ketik NIA, NIS, atau Nama Anggota..." value="{{ $search }}" required autofocus class="input-field">
                <button type="submit" class="btn-check-nia">
                    <i data-lucide="search" style="width: 18px; height: 18px;"></i>
                    Periksa Data Keanggotaan
                </button>
            </form>

            @if($search)
                @if($result)
                    <div class="result-box">
                        <div class="result-header">
                            <i data-lucide="check-circle-2" style="width: 20px; height: 20px;"></i>
                            DATA ANGGOTA RESMI TERDAFTAR
                        </div>
                        <table class="result-table">
                            <tr>
                                <td>Nomor NIA</td>
                                <td style="font-family: monospace; color: var(--green); font-size: 1.05rem;">{{ $result->nia }}</td>
                            </tr>
                            <tr>
                                <td>Nama Anggota</td>
                                <td>{{ strtoupper($result->nama) }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lapangan</td>
                                <td style="color: var(--orange);">"{{ $result->nama_lapangan ?: '-' }}"</td>
                            </tr>
                            <tr>
                                <td>Angkatan</td>
                                <td>{{ $result->angkatan ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><span class="status-badge">AKTIF</span></td>
                            </tr>
                        </table>
                    </div>
                @else
                    <div class="result-not-found">
                        <strong style="color: inherit;">Data Tidak Ditemukan</strong>
                        <p style="margin: 0.3rem 0 0; font-size: 0.88rem;">Nomor NIA atau nama "<b>{{ $search }}</b>" tidak terdaftar di pangkalan data resmi GPA SMK Canda Bhirawa Pare.</p>
                    </div>
                @endif
            @endif
        </div>
    </main>

    <footer class="pub-footer">
        <strong>GENERASI PENCINTA ALAM (GPA)</strong>
        <p>SMK Canda Bhirawa Pare &bull; Jl. Mayjen Mas Isman Tulungrejo, Kec. Pare, Kab. Kediri</p>
        <p style="margin-top: 1rem; color: #475569; font-size: 0.8rem;">&copy; {{ date('Y') }} GPA SMK Canda Bhirawa Pare</p>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>
