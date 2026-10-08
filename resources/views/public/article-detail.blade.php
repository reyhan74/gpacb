<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} — GPA SMK CB Pare</title>
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
        body { font-family: var(--font); background: var(--paper); color: var(--ink); line-height: 1.7; -webkit-font-smoothing: antialiased; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @media (prefers-reduced-motion: reduce) { *, ::before, ::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; transform: none !important; } }

        .pub-navbar { position: sticky; top: 0; z-index: 1000; padding: 0 2rem; height: 72px; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); animation: slideDown 0.5s ease; }
        [data-theme="dark"] .pub-navbar { background: rgba(15,23,42,0.92); }
        .pub-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--green-dark); font-weight: 800; font-size: 1.1rem; }
        [data-theme="dark"] .pub-brand { color: #4ade80; }
        .pub-brand-icon { width: 40px; height: 40px; }
        .pub-nav-links { display: flex; align-items: center; gap: 2rem; list-style: none; }
        .pub-nav-links a { text-decoration: none; color: var(--muted); font-weight: 600; font-size: 0.9rem; transition: color 0.2s; }
        .pub-nav-links a:hover { color: var(--green); }
        .pub-nav-links .btn-login { background: var(--orange); color: #fff; padding: 8px 20px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; transition: all 0.2s; }
        .pub-nav-links .btn-login:hover { background: #c2410c; }
        .mobile-toggle { display: none; background: none; border: 1px solid var(--border); border-radius: 8px; padding: 6px 8px; cursor: pointer; color: var(--ink); }
        @media (max-width: 768px) {
            .pub-navbar { padding: 0 1rem; }
            .pub-nav-links { display: none; position: fixed; top: 72px; left: 0; right: 0; background: var(--paper); flex-direction: column; padding: 1.5rem; gap: 1rem; border-bottom: 1px solid var(--border); }
            .pub-nav-links.open { display: flex; }
            .mobile-toggle { display: block; }
        }

        .article-container { max-width: 900px; margin: 3.5rem auto 4rem; padding: 0 1.5rem; }
        .article-box { background: var(--paper); border: 1px solid var(--border); padding: clamp(1.2rem, 4vw, 3.2rem); border-radius: 24px; box-shadow: 0 16px 42px -12px rgba(0,0,0,.08); animation: fadeInUp .6s ease; }
        [data-theme="dark"] .article-box { background: #111827; border-color: #334155; box-shadow: 0 16px 42px -12px rgba(0,0,0,.35); }
        .article-kicker { display:inline-flex; align-items:center; gap:6px; color:var(--green); background:rgba(23,107,69,.1); padding:6px 11px; border-radius:999px; font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.07em; margin-bottom:1rem; }
        .cover-img { width: 100%; max-height: 470px; object-fit: cover; border-radius: 16px; margin-bottom: 2rem; display:block; }
        .article-box h1 { font-size: clamp(1.65rem, 4vw, 2.7rem); font-weight: 850; color: var(--ink); margin-bottom: .8rem; letter-spacing: -.8px; line-height:1.2; }
        .article-date { font-size: .83rem; color: var(--muted); padding-bottom: 1.4rem; margin-bottom: 1.6rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 6px; font-weight: 600; }
        .article-content { font-size: 1.04rem; color: var(--ink); line-height: 1.9; }
        .article-content p { margin-bottom: 1rem; }
        .article-content::first-letter { font-size:2.8rem; font-weight:800; color:var(--green); float:left; line-height:.9; padding-right:5px; }
        .share-note { margin-top:2rem; padding:1rem 1.1rem; border:1px solid var(--border); border-radius:13px; color:var(--muted); font-size:.82rem; display:flex; align-items:center; gap:8px; }

        .back-link { display: inline-flex; align-items: center; gap: 6px; margin-bottom: 1.5rem; text-decoration: none; color: var(--green); font-weight: 700; font-size: 0.9rem; transition: all 0.2s; }
        .back-link:hover { transform: translateX(-4px); }

        .pub-footer { background: #0f172a; color: #94a3b8; padding: 3rem 2rem; text-align: center; font-size: 0.85rem; }
        .pub-footer strong { color: #fff; display: block; font-size: 1rem; margin-bottom: 0.3rem; }
    </style>
</head>
<body>
    @include('public.partials.navbar')

    <main class="article-container">
        <a href="{{ route('public.articles') }}" class="back-link">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
            Kembali ke Daftar Kegiatan
        </a>

        <article class="article-box">
            <div class="article-kicker">
                <i data-lucide="bookmark" style="width:14px;height:14px;"></i>
                {{ $article->type === 'materi' ? 'Materi Pendidikan' : 'Dokumentasi Kegiatan' }}
            </div>
            @if($article->attachment_path && in_array(strtolower(pathinfo($article->attachment_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                <img src="{{ '/storage/' . ltrim($article->attachment_path, '/') }}" class="cover-img" alt="{{ $article->title }}">
            @endif

            <h1>{{ $article->title }}</h1>
            <div class="article-date">
                <i data-lucide="calendar" style="width: 14px; height: 14px;"></i>
                Dipublikasikan pada {{ $article->created_at->translatedFormat('d F Y H:i') }} WIB
            </div>

            <div class="article-content">
                {!! nl2br(e($article->body)) !!}
            </div>
            <div class="share-note">
                <i data-lucide="heart" style="width:16px;height:16px;color:var(--orange);"></i>
                Bagikan cerita ini dan dukung kegiatan Generasi Pencinta Alam GPA SMK Canda Bhirawa Pare.
            </div>
        </article>
    </main>

    <footer class="pub-footer">
        <strong>GENERASI PENCINTA ALAM (GPA)</strong>
        <p>SMK Canda Bhirawa Pare &bull; Jl. Mayjen Mas Isman Tulungrejo, Kec. Pare, Kab. Kediri</p>
        <p style="margin-top: 1rem; color: #475569; font-size: 0.8rem;">&copy; {{ date('Y') }} GPA SMK Canda Bhirawa Pare</p>
    </footer>

    <script>lucide.createIcons();</script>
</body>
</html>
