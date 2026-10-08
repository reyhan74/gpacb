<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan & Artikel — GPA SMK CB Pare</title>
    <script>
        (function(){
            const t = localStorage.getItem('gpa-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root { --green: #176b45; --green-dark: #104b30; --paper: #f8fafc; --ink: #0f172a; --muted: #64748b; --border: #e2e8f0; --orange: #ea580c; --font: 'Plus Jakarta Sans', -apple-system, sans-serif; }
        [data-theme="dark"] { --paper: #090d16; --ink: #f8fafc; --muted: #94a3b8; --border: #334155; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font); background: var(--paper); color: var(--ink); line-height: 1.6; -webkit-font-smoothing: antialiased; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) { *, ::before, ::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; transform: none !important; } .reveal { opacity: 1; transform: none; } }

        .pub-navbar { position: sticky; top: 0; z-index: 1000; padding: 0 2rem; height: 72px; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); animation: slideDown 0.5s ease; }
        [data-theme="dark"] .pub-navbar { background: rgba(15,23,42,0.92); }
        .pub-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--green-dark); font-weight: 800; font-size: 1.1rem; }
        [data-theme="dark"] .pub-brand { color: #4ade80; }
        .pub-brand-icon { width: 40px; height: 40px; }
        .pub-nav-links { display: flex; align-items: center; gap: 2rem; list-style: none; }
        .pub-nav-links a { text-decoration: none; color: var(--muted); font-weight: 600; font-size: 0.9rem; transition: color 0.2s; }
        .pub-nav-links a:hover { color: var(--green); }
        .pub-nav-links .btn-login { background: var(--orange); color: #fff; padding: 8px 20px; border-radius: 10px; font-weight: 700; font-size: 0.88rem; transition: all 0.2s; }
        .pub-nav-links .btn-login:hover { background: #c2410c; transform: translateY(-2px); }
        .mobile-toggle { display: none; background: none; border: 1px solid var(--border); border-radius: 8px; padding: 6px 8px; cursor: pointer; color: var(--ink); }
        @media (max-width: 768px) {
            .pub-navbar { padding: 0 1rem; }
            .pub-nav-links { display: none; position: fixed; top: 72px; left: 0; right: 0; background: var(--paper); flex-direction: column; padding: 1.5rem; gap: 1rem; border-bottom: 1px solid var(--border); }
            .pub-nav-links.open { display: flex; }
            .mobile-toggle { display: block; }
            .article-filter { flex-wrap:wrap; }
            .filter-search { flex:1 1 100%; }
            .filter-type { flex:1; }
            .filter-button { flex:0 0 auto; }
        }

        .page-header { background: radial-gradient(circle at 82% 20%, rgba(74,222,128,.18), transparent 28%), linear-gradient(135deg, #0a3d22 0%, #176b45 100%); color: #fff; padding: 6.5rem 2rem 4rem; text-align: center; position: relative; overflow: hidden; }
        .page-header h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 0.6rem; animation: fadeInUp 0.6s ease; }
        .page-header p { color: #bbf7d0; font-size: 1rem; max-width: 600px; margin: 0 auto; animation: fadeInUp 0.6s ease 0.15s both; }
        .page-header .eyebrow { display:inline-flex; align-items:center; gap:7px; color:#fed7aa; font-size:.76rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; margin-bottom:1rem; }

        .articles-container { max-width: 1120px; margin: 3rem auto 4rem; padding: 0 1.5rem; }
        .article-filter { display:flex; align-items:center; gap:.65rem; padding:1rem; margin-bottom:1.35rem; background:var(--paper); border:1px solid var(--border); border-radius:16px; box-shadow:0 8px 22px -12px rgba(0,0,0,.12); }
        [data-theme="dark"] .article-filter { background:#111827; border-color:#334155; }
        .filter-search { flex:1; min-width:180px; display:flex; align-items:center; gap:.55rem; color:var(--muted); }
        .filter-search input { width:100%; border:0; outline:0; background:transparent; color:var(--ink); font:inherit; font-size:.86rem; }
        .filter-type { border:1px solid var(--border); border-radius:9px; padding:.55rem .7rem; background:var(--paper); color:var(--ink); font:inherit; font-size:.8rem; }
        .filter-button { display:inline-flex; align-items:center; gap:.35rem; border:0; border-radius:9px; padding:.58rem .9rem; background:var(--green); color:#fff; font-size:.8rem; font-weight:800; cursor:pointer; }
        .filter-button:hover { background:var(--green-dark); }
        .filter-reset { color:var(--muted); font-size:.8rem; font-weight:700; text-decoration:none; padding:.4rem; }
        .filter-reset:hover { color:var(--green); }
        .articles-toolbar { display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.3rem; color:var(--muted); font-size:.85rem; font-weight:600; }
        .articles-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 1.35rem; }
        .article-card { background: var(--paper); border: 1px solid var(--border); border-radius: 18px; overflow: hidden; text-decoration: none; color: inherit; display: flex; flex-direction: column; transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease; }
        [data-theme="dark"] .article-card { background: #111827; border-color: #334155; }
        .article-card:hover { transform: translateY(-6px); box-shadow: 0 18px 38px -12px rgba(16,75,48,.22); border-color: rgba(23,107,69,.45); }
        .article-cover { height: 205px; position:relative; overflow:hidden; background:linear-gradient(135deg,#104b30,#176b45); }
        .article-card img { width: 100%; height: 100%; object-fit: cover; display:block; transition:transform .5s ease; }
        .article-card:hover img { transform:scale(1.06); }
        .article-cover::after { content:''; position:absolute; inset:0; background:linear-gradient(180deg,transparent 48%,rgba(0,0,0,.42)); pointer-events:none; }
        .article-type { position:absolute; z-index:2; left:13px; top:13px; padding:5px 10px; border-radius:999px; background:rgba(255,255,255,.92); color:#176b45; font-size:.68rem; font-weight:800; text-transform:uppercase; letter-spacing:.06em; }
        .article-card-body { padding: 1.25rem 1.3rem 1.35rem; flex: 1; display: flex; flex-direction: column; }
        .article-card-body h3 { font-size: 1.05rem; font-weight: 800; margin-bottom: .55rem; color: var(--ink); line-height:1.35; }
        .article-card-body p { font-size: .86rem; color: var(--muted); margin-bottom: 1rem; line-height: 1.6; }
        .article-meta { font-size: .76rem; color: var(--muted); margin-top: auto; font-weight: 600; display:flex; align-items:center; justify-content:space-between; gap:1rem; }
        .article-read { color:var(--green); font-weight:800; white-space:nowrap; }
        .article-placeholder { grid-column: 1 / -1; text-align: center; padding: 3rem; background: var(--paper); border: 1px solid var(--border); border-radius: 16px; color: var(--muted); }
        [data-theme="dark"] .article-placeholder { background: #111827; border-color: #334155; }

        .pagination-wrapper { margin-top: 2rem; display: flex; justify-content: center; }
        .pagination-wrapper .pagination { margin:0; gap:5px; }
        .pagination-wrapper .page-link { border:1px solid var(--border); color:var(--green); background:var(--paper); border-radius:9px !important; font-size:.82rem; font-weight:700; min-width:38px; text-align:center; box-shadow:none; }
        .pagination-wrapper .page-link:hover { color:#fff; background:var(--green); border-color:var(--green); }
        .pagination-wrapper .page-item.active .page-link { color:#fff; background:var(--green); border-color:var(--green); }
        .pagination-wrapper .page-item.disabled .page-link { color:var(--muted); opacity:.5; background:var(--paper); }
        [data-theme="dark"] .pagination-wrapper .page-link { background:#111827; border-color:#334155; }
        [data-theme="dark"] .pagination-wrapper .page-item.disabled .page-link { background:#111827; }

        .pub-footer { background: #0f172a; color: #94a3b8; padding: 3rem 2rem; text-align: center; font-size: 0.85rem; }
        .pub-footer strong { color: #fff; display: block; font-size: 1rem; margin-bottom: 0.3rem; }
    </style>
</head>
<body>
    @include('public.partials.navbar')

    <div class="page-header">
        <div class="eyebrow"><i data-lucide="compass" style="width:15px;height:15px;"></i> Cerita & Dokumentasi GPA</div>
        <h1>Kegiatan & Catatan Ekspedisi</h1>
        <p>Jelajahi cerita perjalanan, berita kegiatan, dan pengalaman anggota Generasi Pencinta Alam.</p>
    </div>

    <main class="articles-container">
        <form method="GET" action="{{ route('public.articles') }}" class="article-filter">
            <div class="filter-search">
                <i data-lucide="search" style="width:16px;height:16px;"></i>
                <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul atau isi kegiatan..." aria-label="Cari artikel">
            </div>
            <select name="type" class="filter-type" aria-label="Filter tipe artikel">
                <option value="">Semua kategori</option>
                <option value="berita" @selected($type === 'berita')>Kegiatan / Berita</option>
                <option value="materi" @selected($type === 'materi')>Materi Pendidikan</option>
            </select>
            <button type="submit" class="filter-button"><i data-lucide="search" style="width:15px;height:15px;"></i> Cari</button>
            @if($search || $type)
                <a href="{{ route('public.articles') }}" class="filter-reset">Reset</a>
            @endif
        </form>
        <div class="articles-toolbar">
            <span><i data-lucide="layers" style="width:15px;height:15px;vertical-align:-3px;"></i> {{ $search || $type ? 'Hasil pencarian' : 'Publikasi terbaru GPA' }}</span>
            <span>{{ $articles->total() }} artikel</span>
        </div>
        <div class="articles-grid">
            @forelse($articles as $art)
                <a href="{{ route('public.article.show', \Illuminate\Support\Str::slug($art->title)) }}" class="article-card reveal">
                    <div class="article-cover">
                        <span class="article-type">{{ $art->type === 'materi' ? 'Materi' : 'Kegiatan' }}</span>
                        @if($art->attachment_path && in_array(strtolower(pathinfo($art->attachment_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                            <img src="{{ '/storage/' . ltrim($art->attachment_path, '/') }}" alt="{{ $art->title }}">
                        @else
                            <div style="height:100%;display:grid;place-items:center;color:rgba(255,255,255,.7);font-weight:800;font-size:.85rem;letter-spacing:.1em;"><i data-lucide="mountain" style="width:38px;height:38px;"></i></div>
                        @endif
                    </div>
                    <div class="article-card-body">
                        <h3>{{ $art->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($art->body), 120) ?: 'Dokumentasi dan informasi kegiatan Generasi Pencinta Alam SMK Canda Bhirawa Pare.' }}</p>
                        <div class="article-meta">
                            <span><i data-lucide="calendar" style="width:13px;height:13px;vertical-align:-2px;"></i> {{ $art->created_at->translatedFormat('d F Y') }}</span>
                            <span class="article-read">Baca <i data-lucide="arrow-up-right" style="width:13px;height:13px;vertical-align:-2px;"></i></span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="article-placeholder">
                    <i data-lucide="newspaper" style="width: 40px; height: 40px; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="font-weight: 600;">Belum ada artikel kegiatan yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $articles->links() }}
        </div>
    </main>

    <footer class="pub-footer">
        <strong>GENERASI PENCINTA ALAM (GPA)</strong>
        <p>SMK Canda Bhirawa Pare &bull; Jl. Mayjen Mas Isman Tulungrejo, Kec. Pare, Kab. Kediri</p>
        <p style="margin-top: 1rem; color: #475569; font-size: 0.8rem;">&copy; {{ date('Y') }} GPA SMK Canda Bhirawa Pare</p>
    </footer>

    <script>
        lucide.createIcons();
        const obs = new IntersectionObserver(e => e.forEach(x => { if (x.isIntersecting) { x.target.classList.add('visible'); obs.unobserve(x.target); } }), { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
    </script>
</body>
</html>
