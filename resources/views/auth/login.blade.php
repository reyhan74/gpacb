<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Anggota & Pengelola — GPA SMK CB Pare</title>
    <link rel="icon" type="image/png" href="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
        :root { --green: #176b45; --green-dark: #104b30; --orange: #ea580c; --paper: #f8fafc; --ink: #0f172a; --muted: #64748b; --border: #e2e8f0; }
        [data-theme="dark"] { --paper: #090d16; --ink: #f8fafc; --muted: #94a3b8; --border: #334155; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #104b30 0%, #176b45 50%, #0f172a 100%);
            -webkit-font-smoothing: antialiased;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @media (prefers-reduced-motion: reduce) { *, ::before, ::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; } }

        .login-card {
            background: var(--paper);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            width: min(460px, 100%);
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            border: 1px solid var(--border);
            animation: fadeInUp 0.6s ease;
            position: relative;
            overflow: hidden;
        }
        [data-theme="dark"] .login-card { background: #111827; }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #104b30, #22c55e, #176b45);
        }

        .brand-area {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 1rem;
        }
        @media (max-width: 576px) {
            .brand-icon { width: 64px; height: 64px; }
        }
        .brand-icon img {
            object-position: center;
        }
        .brand-tag {
            display: inline-block;
            background: rgba(22, 101, 52, 0.1);
            color: var(--green-dark);
            padding: 4px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.6rem;
        }
        [data-theme="dark"] .brand-tag { background: rgba(74, 222, 128, 0.1); color: #4ade80; }
        .brand-area h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }
        .brand-area p {
            color: var(--muted);
            font-size: 0.88rem;
            line-height: 1.5;
        }
        .brand-area code {
            background: rgba(22,101,52,0.08);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--green);
        }

        .error-box {
            background: #fef2f2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        [data-theme="dark"] .error-box { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2); color: #fca5a5; }

        label {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--ink);
            margin-bottom: 6px;
        }
        .input-field {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            background: var(--paper);
            color: var(--ink);
            margin-bottom: 1.2rem;
            transition: all 0.2s ease;
        }
        [data-theme="dark"] .input-field { background: #0f172a; border-color: #334155; color: #f8fafc; }
        .input-field:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 4px rgba(22,101,52,0.15);
            transform: translateY(-1px);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        .remember-check {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            color: var(--muted);
            font-weight: 600;
        }
        .remember-check input { width: auto; margin: 0; accent-color: var(--green); }
        .forgot-link { color: var(--orange); text-decoration: none; font-weight: 700; }
        .forgot-link:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #104b30, #176b45);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(16,75,48,0.35);
        }
        .btn-submit:active { transform: scale(0.97) translateY(0); }

        .footer-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.88rem;
            color: var(--muted);
        }
        .footer-link a { color: var(--green); text-decoration: none; font-weight: 700; }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <main class="login-card">
        <div class="brand-area">
            <div class="brand-icon d-flex align-items-center justify-content-center rounded-circle bg-white p-1 shadow flex-shrink-0"><img class="w-100 h-100 d-block object-fit-contain rounded-circle" src="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}" alt="Logo GPA"></div>
            <div class="brand-tag">Portal GPA SMK CB Pare</div>
            <h1>Masuk ke Sistem</h1>
            <p>Anggota gunakan <strong>NIA</strong>. Calon anggota gunakan <strong>kode pendaftaran</strong> dan nomor WhatsApp sebagai password awal.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink:0;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label>Nomor NIA atau Email</label>
            <input name="email" type="text" value="{{ old('email') }}" placeholder="Contoh: GPA.XXIV.021" required autofocus class="input-field">

            <label>Kata Sandi (Default: Nomor NIS)</label>
            <input name="password" type="password" placeholder="Masukkan kata sandi" required class="input-field">

            <div class="options-row">
                <label class="remember-check">
                    <input name="remember" type="checkbox"> Ingat saya
                </label>
                <a href="{{ route('public.check-nia') }}" class="forgot-link">Lupa NIA?</a>
            </div>

            <button type="submit" class="btn-submit">
                <i data-lucide="log-in" style="width: 18px; height: 18px;"></i>
                Masuk ke Portal
            </button>
        </form>

        <div class="footer-link">
            &larr; <a href="{{ route('home') }}">Kembali ke Halaman Utama</a>
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>
