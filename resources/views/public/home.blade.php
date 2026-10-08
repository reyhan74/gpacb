<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generasi Pencinta Alam — SMK Canda Bhirawa Pare</title>
    <link rel="icon" type="image/png" href="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="description" content="Website resmi Generasi Pencinta Alam (GPA) SMK Canda Bhirawa Pare Kediri. One Step For One Earth. Verifikasi NIA, kegiatan, dan portal anggota.">

    <script>
        (function(){
            const t = localStorage.getItem('gpa-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --green-900:#0a3d22; --green-800:#104b30; --green-700:#176b45; --green-600:#1a8a58;
            --green-500:#22c55e; --green-400:#4ade80; --green-100:#dcfce7; --green-50:#f0fdf4;
            --navy:#0f172a; --navy-800:#1e293b; --navy-700:#334155;
            --paper:#f8fafc; --ink:#0f172a; --muted:#64748b; --border:#e2e8f0;
            --orange:#ea580c; --orange-light:#fed7aa;
            --font:'Plus Jakarta Sans',-apple-system,sans-serif;
        }
        [data-theme="dark"] {
            --paper:#090d16; --ink:#f1f5f9; --muted:#94a3b8; --border:rgba(255,255,255,0.08);
        }

        *{box-sizing:border-box;margin:0;padding:0;}
        html{scroll-behavior:smooth;}
        body{font-family:var(--font);background:var(--paper);color:var(--ink);line-height:1.6;overflow-x:hidden;-webkit-font-smoothing:antialiased;}

        /* ANIMATIONS */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(32px);}to{opacity:1;transform:translateY(0);}}
        @keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
        @keyframes scaleIn{from{opacity:0;transform:scale(0.85);}to{opacity:1;transform:scale(1);}}
        @keyframes slideDown{from{opacity:0;transform:translateY(-20px);}to{opacity:1;transform:translateY(0);}}
        @keyframes pulse{0%,100%{opacity:1;}50%{opacity:.6;}}
        @keyframes float{0%,100%{transform:translateY(0);}50%{transform:translateY(-6px);}}
        .reveal{opacity:0;transform:translateY(28px);transition:opacity .7s ease,transform .7s ease;}
        .reveal.visible{opacity:1;transform:translateY(0);}
        @media(prefers-reduced-motion:reduce){*,::before,::after{animation-duration:.01ms!important;transition-duration:.01ms!important;}.reveal{opacity:1;transform:none;}}

        /* NAVBAR */
        .pub-navbar{position:fixed;top:0;left:0;right:0;z-index:1000;padding:0 2rem;height:68px;display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,0.9);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-bottom:1px solid var(--border);transition:all .3s ease;animation:slideDown .5s ease;}
        [data-theme="dark"] .pub-navbar{background:rgba(15,23,42,0.9);}
        .pub-navbar.scrolled{box-shadow:0 4px 24px rgba(0,0,0,0.06);}
        .pub-brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--green-800);font-weight:800;font-size:1rem;}
        [data-theme="dark"] .pub-brand{color:var(--green-400);}
        .pub-brand-icon{width:40px;height:40px;}
        .pub-nav-links{display:flex;align-items:center;gap:1.8rem;list-style:none;}
        .pub-nav-links a{text-decoration:none;color:var(--muted);font-weight:600;font-size:.88rem;transition:color .2s;}
        .pub-nav-links a:hover{color:var(--green-700);}
        .pub-nav-links .btn-login{background:var(--orange);color:#fff;padding:8px 18px;border-radius:10px;font-weight:700;font-size:.85rem;transition:all .2s;}
        .pub-nav-links .btn-login:hover{background:#c2410c;transform:translateY(-2px);box-shadow:0 6px 16px rgba(234,88,12,0.3);}
        .mobile-toggle{display:none;background:none;border:1px solid var(--border);border-radius:8px;padding:6px 8px;cursor:pointer;color:var(--ink);}
        @media(max-width:768px){
            .pub-navbar{padding:0 1rem;}
            .pub-nav-links{display:none;position:fixed;top:68px;left:0;right:0;background:var(--paper);flex-direction:column;padding:1.5rem;gap:1rem;border-bottom:1px solid var(--border);box-shadow:0 10px 30px rgba(0,0,0,0.08);}
            .pub-nav-links.open{display:flex;animation:slideDown .3s ease;}
            .mobile-toggle{display:block;}
        }

        /* HERO */
        .hero{color:#fff;padding:9rem 2rem 5rem;text-align:center;position:relative;overflow:hidden;background:linear-gradient(120deg,#38bdf8 0%,#60a5fa 35%,#818cf8 70%,#38bdf8 100%);background-size:240% 240%;animation:heroBlueShift 16s ease-in-out infinite;isolation:isolate;}
        .hero::before{content:'';position:absolute;inset:-35% -10%;background:radial-gradient(circle at 18% 25%,rgba(224,242,254,.42),transparent 28%),radial-gradient(circle at 82% 20%,rgba(186,230,253,.34),transparent 30%),radial-gradient(circle at 55% 100%,rgba(30,64,175,.22),transparent 42%);pointer-events:none;z-index:-1;animation:heroGlow 10s ease-in-out infinite alternate;}
        .hero::after{content:'';position:absolute;bottom:-45%;left:12%;width:70%;height:70%;border-radius:50%;border:1px solid rgba(255,255,255,.22);box-shadow:0 0 0 28px rgba(255,255,255,.06),0 0 0 56px rgba(255,255,255,.035);pointer-events:none;z-index:-1;animation:heroOrbit 14s ease-in-out infinite alternate;}
        @keyframes heroBlueShift{0%,100%{background-position:0% 50%;}50%{background-position:100% 50%;}}
        @keyframes heroGlow{from{transform:translate3d(-2%,0,0) scale(1);}to{transform:translate3d(3%,2%,0) scale(1.08);}}
        @keyframes heroOrbit{from{transform:translateX(-3%) rotate(-2deg);}to{transform:translateX(3%) rotate(2deg);}}
        .hero-content{position:relative;z-index:2;max-width:820px;margin:0 auto;}
        @media (prefers-reduced-motion: reduce){.hero,.hero::before,.hero::after{animation:none;}}
        .hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.12);backdrop-filter:blur(6px);color:var(--green-100);padding:8px 18px;border-radius:24px;font-size:.78rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:1.2rem;animation:fadeIn .8s ease .2s both;}
        .hero-motto{font-size:1.1rem;color:var(--orange-light);font-weight:700;letter-spacing:.15em;text-transform:uppercase;margin-bottom:.8rem;animation:fadeIn .8s ease .25s both;}
        .hero h1{font-size:3.8rem;font-weight:900;letter-spacing:-1.5px;line-height:1.05;margin-bottom:.8rem;animation:fadeInUp .8s ease .3s both;}
        .hero h1 span{display:block;font-size:1.1rem;font-weight:600;letter-spacing:.2em;color:var(--green-100);margin-top:.4rem;text-transform:uppercase;}
        .hero-desc{font-size:1.05rem;color:#bbf7d0;max-width:600px;margin:0 auto 2rem;line-height:1.7;animation:fadeInUp .8s ease .5s both;}
        .hero-actions{display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;animation:fadeInUp .8s ease .7s both;}
        .hero-btn{display:inline-flex;align-items:center;gap:8px;padding:14px 26px;border-radius:14px;text-decoration:none;font-weight:700;font-size:.95rem;transition:all .25s ease;}
        .hero-btn-primary{background:#fff;color:var(--green-800);box-shadow:0 8px 24px rgba(0,0,0,0.15);}
        .hero-btn-primary:hover{transform:translateY(-3px);box-shadow:0 12px 32px rgba(0,0,0,0.2);}
        .hero-btn-secondary{background:rgba(255,255,255,0.12);color:#fff;backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,0.2);}
        .hero-btn-secondary:hover{background:rgba(255,255,255,0.22);transform:translateY(-3px);}
        @media(max-width:768px){.hero{padding:7rem 1.2rem 3.5rem;}.hero h1{font-size:2.4rem;}.hero-desc{font-size:.95rem;}.hero-motto{font-size:.9rem;}}

        /* STATS */
        .stats-section{max-width:1100px;margin:-3rem auto 0;padding:0 1.5rem;position:relative;z-index:10;}
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;}
        .stat-card{background:var(--paper);border:1px solid var(--border);border-radius:18px;padding:1.5rem 1rem;text-align:center;box-shadow:0 10px 28px -8px rgba(0,0,0,0.07);transition:transform .3s,box-shadow .3s;animation:scaleIn .5s ease both;}
        [data-theme="dark"] .stat-card{background:#111827;border-color:var(--navy-700);box-shadow:0 10px 28px -8px rgba(0,0,0,0.3);}
        .stat-card:hover{transform:translateY(-4px);box-shadow:0 16px 36px -8px rgba(0,0,0,0.12);}
        .stat-card:nth-child(1){animation-delay:.1s;}.stat-card:nth-child(2){animation-delay:.15s;}.stat-card:nth-child(3){animation-delay:.2s;}.stat-card:nth-child(4){animation-delay:.25s;}
        .stat-icon{width:44px;height:44px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:.6rem;}
        .si-green{background:rgba(22,101,52,0.1);color:#166534;} .si-blue{background:rgba(59,130,246,0.1);color:#3b82f6;}
        .si-orange{background:rgba(234,88,12,0.1);color:#ea580c;} .si-pink{background:rgba(219,39,119,0.1);color:#db2777;}
        .stat-value{font-size:2.2rem;font-weight:800;color:var(--green-700);line-height:1;margin-bottom:.2rem;}
        [data-theme="dark"] .stat-value{color:var(--green-400);}
        .stat-label{font-size:.75rem;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.05em;}
        @media(max-width:768px){.stats-grid{grid-template-columns:repeat(2,1fr);}.stat-value{font-size:1.8rem;}}
        @media(max-width:420px){.stats-grid{grid-template-columns:1fr;}}

        /* SECTION COMMON */
        .section-wrap{max-width:1100px;margin:0 auto;padding:4.5rem 1.5rem;}
        .section-header{text-align:center;margin-bottom:2.5rem;}
        .section-header h2{font-size:1.8rem;font-weight:800;color:var(--green-800);letter-spacing:-.5px;margin-bottom:.4rem;}
        [data-theme="dark"] .section-header h2{color:var(--green-400);}
        .section-header p{color:var(--muted);font-size:.95rem;max-width:580px;margin:0 auto;}
        .section-divider{width:48px;height:3px;background:var(--green-700);border-radius:2px;margin:0 auto 1rem;}

        /* KEGIATAN UNGGULAN */
        .kegiatan-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;}
        .kegiatan-card{background:var(--paper);border:1px solid var(--border);border-radius:16px;padding:1.5rem 1rem;text-align:center;transition:transform .3s,box-shadow .3s;}
        [data-theme="dark"] .kegiatan-card{background:#111827;border-color:var(--navy-700);}
        .kegiatan-card:hover{transform:translateY(-4px);box-shadow:0 12px 28px -6px rgba(0,0,0,0.1);}
        .kegiatan-icon{width:48px;height:48px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:.8rem;transition:transform .3s cubic-bezier(.34,1.56,.64,1);}
        .kegiatan-card:hover .kegiatan-icon{transform:scale(1.12) rotate(3deg);}
        .kegiatan-card h3{font-size:.88rem;font-weight:700;color:var(--ink);margin-bottom:.3rem;}
        .kegiatan-card p{font-size:.78rem;color:var(--muted);line-height:1.5;}

        /* PILAR */
        .pilar-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.2rem;}
        .pilar-card{background:var(--paper);border:1px solid var(--border);border-radius:18px;padding:2rem 1.5rem;transition:transform .3s,box-shadow .3s;position:relative;overflow:hidden;}
        [data-theme="dark"] .pilar-card{background:#111827;border-color:var(--navy-700);}
        .pilar-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px -8px rgba(0,0,0,0.1);}
        .pilar-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;}
        .pilar-card:nth-child(1)::before{background:var(--green-700);}.pilar-card:nth-child(2)::before{background:#3b82f6;}.pilar-card:nth-child(3)::before{background:var(--orange);}.pilar-card:nth-child(4)::before{background:#8b5cf6;}
        .pilar-icon{width:52px;height:52px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;transition:transform .35s cubic-bezier(.34,1.56,.64,1);}
        .pilar-card:hover .pilar-icon{transform:scale(1.12) rotate(3deg);}
        .pi-green{background:rgba(22,101,52,0.1);color:#166534;} .pi-blue{background:rgba(59,130,246,0.1);color:#3b82f6;}
        .pi-orange{background:rgba(234,88,12,0.1);color:#ea580c;} .pi-purple{background:rgba(139,92,246,0.1);color:#8b5cf6;}
        .pilar-card h3{font-size:1.05rem;font-weight:700;color:var(--ink);margin-bottom:.4rem;}
        .pilar-card p{font-size:.88rem;color:var(--muted);line-height:1.6;}

        /* INSTAGRAM CTA */
        .ig-section{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-800) 100%);padding:4rem 1.5rem;text-align:center;position:relative;overflow:hidden;}
        .ig-section::before{content:'';position:absolute;top:-30%;right:-10%;width:400px;height:400px;border-radius:50%;background:rgba(234,88,12,0.04);}
        .ig-inner{max-width:700px;margin:0 auto;position:relative;z-index:2;}
        .ig-icon{width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.2rem;}
        .ig-section h2{color:#fff;font-size:1.6rem;font-weight:800;margin-bottom:.6rem;}
        .ig-section .ig-handle{color:var(--green-400);font-size:1.1rem;font-weight:700;margin-bottom:.6rem;}
        .ig-section .ig-bio{color:#94a3b8;font-size:.95rem;margin-bottom:1.5rem;line-height:1.6;}
        .ig-highlights{display:flex;justify-content:center;gap:.6rem;flex-wrap:wrap;margin-bottom:2rem;}
        .ig-hl{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);color:#cbd5e1;padding:6px 14px;border-radius:20px;font-size:.75rem;font-weight:600;transition:all .2s;}
        .ig-hl:hover{background:rgba(255,255,255,0.15);color:#fff;}
        .ig-btn{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#f09433,#dc2743,#bc1888);color:#fff;padding:14px 28px;border-radius:14px;text-decoration:none;font-weight:700;font-size:.95rem;transition:all .25s;box-shadow:0 6px 20px rgba(220,39,67,0.3);}
        .ig-btn:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(220,39,67,0.4);}

        /* CTA JOIN */
        .cta-section{background:linear-gradient(135deg,var(--green-800) 0%,var(--green-700) 100%);padding:4.5rem 1.5rem;text-align:center;position:relative;overflow:hidden;}
        .cta-section::before{content:'';position:absolute;top:-30%;left:-10%;width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,0.03);}
        .cta-inner{max-width:680px;margin:0 auto;position:relative;z-index:2;}
        .cta-section h2{color:#fff;font-size:2rem;font-weight:800;margin-bottom:.6rem;}
        .cta-section p{color:#bbf7d0;font-size:1rem;margin-bottom:2rem;line-height:1.7;}
        .cta-btn{display:inline-flex;align-items:center;gap:8px;background:#fff;color:var(--green-800);padding:14px 32px;border-radius:14px;text-decoration:none;font-weight:700;font-size:1rem;box-shadow:0 8px 24px rgba(0,0,0,0.15);transition:all .25s;}
        .cta-btn:hover{transform:translateY(-3px);box-shadow:0 12px 32px rgba(0,0,0,0.2);}

        /* ARTICLES */
        .articles-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.2rem;}
        .article-card{background:var(--paper);border:1px solid var(--border);border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;display:flex;flex-direction:column;transition:transform .3s,box-shadow .3s;}
        [data-theme="dark"] .article-card{background:#111827;border-color:var(--navy-700);}
        .article-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px -8px rgba(0,0,0,0.1);}
        .article-cover{height:180px;position:relative;overflow:hidden;background:linear-gradient(135deg,var(--green-800),var(--green-700));}
        .article-cover img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease;}
        .article-card:hover .article-cover img{transform:scale(1.06);}
        .article-cover::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 45%,rgba(0,0,0,.38));pointer-events:none;}
        .article-type{position:absolute;z-index:2;left:12px;top:12px;padding:5px 9px;border-radius:999px;background:rgba(255,255,255,.92);color:var(--green-700);font-size:.65rem;font-weight:800;text-transform:uppercase;}
        .article-card-body{padding:1.2rem;flex:1;display:flex;flex-direction:column;}
        .article-card-body h3{font-size:1rem;font-weight:800;margin-bottom:.4rem;color:var(--ink);line-height:1.35;}
        .article-card-body p{font-size:.85rem;color:var(--muted);margin-bottom:.8rem;line-height:1.5;}
        .article-meta{font-size:.75rem;color:var(--muted);margin-top:auto;font-weight:600;display:flex;justify-content:space-between;gap:.5rem;}
        .article-read{color:var(--green-700);font-weight:800;white-space:nowrap;}
        .article-placeholder{grid-column:1/-1;text-align:center;padding:3rem;background:var(--paper);border:1px solid var(--border);border-radius:16px;color:var(--muted);}
        [data-theme="dark"] .article-placeholder{background:#111827;border-color:var(--navy-700);}

        /* FOOTER */
        .pub-footer{background:var(--navy);color:#94a3b8;padding:3.5rem 2rem 1.5rem;margin-top:0;}
        .footer-inner{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:2.5rem;}
        .footer-brand h3{color:#fff;font-size:1.1rem;font-weight:800;margin-bottom:.6rem;}
        .footer-brand p{font-size:.85rem;line-height:1.7;}
        .footer-col h4{color:#fff;font-size:.82rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.8rem;}
        .footer-col a{display:block;color:#94a3b8;text-decoration:none;font-size:.85rem;padding:3px 0;transition:color .2s;}
        .footer-col a:hover{color:var(--green-400);}
        .footer-social{display:flex;gap:.6rem;margin-top:1rem;}
        .footer-social a{width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,0.06);display:grid;place-items:center;color:#94a3b8;transition:all .2s;text-decoration:none;}
        .footer-social a:hover{background:var(--green-700);color:#fff;}
        .footer-bottom{max-width:1100px;margin:2.5rem auto 0;padding-top:1.5rem;border-top:1px solid rgba(255,255,255,0.06);text-align:center;font-size:.78rem;color:#475569;}
        @media(max-width:768px){.footer-inner{grid-template-columns:1fr;gap:1.5rem;}}
    </style>
</head>
<body>

    <!-- NAVBAR -->
    @include('public.partials.navbar')

    <!-- HERO -->
    <header class="hero">
        <div class="hero-content">
            <span class="hero-badge">
                <i data-lucide="mountain" style="width:14px;height:14px;"></i>
                Ekstrakurikuler Pencinta Alam
            </span>
            <div class="hero-motto">💎 One Step For One Earth</div>
            <h1>GENERASI<br>PENCINTA ALAM
                <span>SMK Canda Bhirawa Pare — Kediri</span>
            </h1>
            <p class="hero-desc">Membentuk karakter pemuda berwawasan lingkungan, tangguh di alam bebas, dan berintegritas tinggi melalui pendidikan, pelatihan, dan aksi nyata pelestarian alam.</p>
            <div class="hero-actions">
                <a href="{{ route('public.candidates.create') }}" class="hero-btn hero-btn-primary">
                    <i data-lucide="user-plus" style="width:18px;height:18px;"></i>
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="hero-btn hero-btn-secondary">
                    <i data-lucide="id-card" style="width:18px;height:18px;"></i>
                    Portal Anggota
                </a>
            </div>
        </div>
    </header>

    <!-- STATISTICS -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon si-green"><i data-lucide="users" style="width:22px;height:22px;"></i></div>
                <div class="stat-value" data-count="{{ $totalAnggota }}">0</div>
                <div class="stat-label">Total Anggota</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon si-blue"><i data-lucide="layers" style="width:22px;height:22px;"></i></div>
                <div class="stat-value" data-count="{{ $totalAngkatan }}">0</div>
                <div class="stat-label">Angkatan Terdata</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon si-orange"><i data-lucide="id-card" style="width:22px;height:22px;"></i></div>
                <div class="stat-value">100%</div>
                <div class="stat-label">KTA Digital Resmi</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon si-pink"><i data-lucide="instagram" style="width:22px;height:22px;"></i></div>
                <div class="stat-value" data-count="549">0</div>
                <div class="stat-label">Followers Instagram</div>
            </div>
        </div>
    </section>

    <!-- KEGIATAN UNGGULAN -->
    <section class="section-wrap reveal">
        <div class="section-header">
            <div class="section-divider"></div>
            <h2>Kegiatan Unggulan GPA</h2>
            <p>Program rutin dan agenda tahunan yang menjadi ciri khas Generasi Pencinta Alam SMK CB Pare.</p>
        </div>
        <div class="kegiatan-grid">
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(22,101,52,0.1);color:#166534;">
                    <i data-lucide="calendar-check" style="width:24px;height:24px;"></i>
                </div>
                <h3>Latihan Mingguan</h3>
                <p>Latihan fisik, teknik, dan materi keorganisasian setiap minggu</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(234,88,12,0.1);color:#ea580c;">
                    <i data-lucide="shield-alert" style="width:24px;height:24px;"></i>
                </div>
                <h3>DIKLAT SAR</h3>
                <p>Pendidikan & Latihan Search and Rescue bersama tim SAR profesional</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6;">
                    <i data-lucide="tent" style="width:24px;height:24px;"></i>
                </div>
                <h3>Fun Camp</h3>
                <p>Perkemahan rekreatif untuk mempererat kekeluargaan antar angkatan</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6;">
                    <i data-lucide="mountain-snow" style="width:24px;height:24px;"></i>
                </div>
                <h3>GMP (Gladian Medan Pendakian)</h3>
                <p>Gladian pendakian gunung sebagai ujian akhir kemampuan anggota</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(219,39,119,0.1);color:#db2777;">
                    <i data-lucide="compass" style="width:24px;height:24px;"></i>
                </div>
                <h3>GPA Dolan</h3>
                <p>Eksplorasi wisata alam dan edukasi lingkungan bersama seluruh anggota</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                    <i data-lucide="clipboard-list" style="width:24px;height:24px;"></i>
                </div>
                <h3>RAT (Rapat Anggota Tahunan)</h3>
                <p>Musyawarah tahunan evaluasi program dan pemilihan kepengurusan baru</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(16,185,129,0.1);color:#10b981;">
                    <i data-lucide="utensils" style="width:24px;height:24px;"></i>
                </div>
                <h3>Bukber & Bakar-Bakar</h3>
                <p>Momen kebersamaan buka bersama dan acara bonfire antar anggota</p>
            </div>
            <div class="kegiatan-card reveal">
                <div class="kegiatan-icon" style="background:rgba(99,102,241,0.1);color:#6366f1;">
                    <i data-lucide="graduation-cap" style="width:24px;height:24px;"></i>
                </div>
                <h3>DIKSAR (Pendidikan Dasar)</h3>
                <p>Pelatihan dasar calon anggota baru: navigasi, survival, dan mental</p>
            </div>
        </div>
    </section>

    <!-- PILAR ORGANISASI -->
    <section class="section-wrap reveal" id="pilar">
        <div class="section-header">
            <div class="section-divider"></div>
            <h2>Empat Pilar Organisasi</h2>
            <p>Fondasi kegiatan yang membentuk karakter dan kompetensi setiap anggota GPA.</p>
        </div>
        <div class="pilar-grid">
            <div class="pilar-card reveal">
                <div class="pilar-icon pi-green">
                    <i data-lucide="graduation-cap" style="width:26px;height:26px;"></i>
                </div>
                <h3>Pendidikan & Pelatihan</h3>
                <p>DIKSAR, DIKLAT SAR, pelatihan navigasi darat, P3K, tali-temali, dan survival di alam terbuka. Materi diajarkan oleh senior berpengalaman dan instruktur profesional.</p>
            </div>
            <div class="pilar-card reveal">
                <div class="pilar-icon pi-blue">
                    <i data-lucide="mountain" style="width:26px;height:26px;"></i>
                </div>
                <h3>Ekspedisi & Pendakian</h3>
                <p>Pendakian gunung-gunung di Jawa Timur dan Nusantara — Arjuno, Welirang, Semeru, Lawu — sebagai ujian ketahanan fisik, mental, dan kekompakan tim.</p>
            </div>
            <div class="pilar-card reveal">
                <div class="pilar-icon pi-orange">
                    <i data-lucide="leaf" style="width:26px;height:26px;"></i>
                </div>
                <h3>Konservasi & Lingkungan</h3>
                <p>Aksi bersih sungai, reboisasi, pengolahan sampah, dan edukasi pelestarian alam kepada masyarakat sekitar Kab. Kediri. Berkolaborasi dengan Forum Kali Brantas.</p>
            </div>
            <div class="pilar-card reveal">
                <div class="pilar-icon pi-purple">
                    <i data-lucide="anchor" style="width:26px;height:26px;"></i>
                </div>
                <h3>Panjat Tebing & Keahlian</h3>
                <p>Latihan rock climbing indoor & outdoor, rappelling, serta vertical rescue. Meningkatkan kekuatan fisik, keberanian, dan keterampilan teknis ketinggian.</p>
            </div>
        </div>
    </section>

    <!-- ARTIKEL KEGIATAN -->
    <section class="section-wrap reveal">
        <div class="section-header">
            <div class="section-divider"></div>
            <h2>Dokumentasi & Kegiatan Terbaru</h2>
            <p>Catatan ekspedisi, berita kegiatan, dan publikasi resmi organisasi.</p>
        </div>
        <div class="articles-grid">
            @forelse($articles as $art)
                <a href="{{ route('public.article.show', \Illuminate\Support\Str::slug($art->title)) }}" class="article-card reveal">
                    <div class="article-cover">
                        <span class="article-type">{{ $art->type === 'materi' ? 'Materi' : 'Kegiatan' }}</span>
                        @if($art->attachment_path && in_array(strtolower(pathinfo($art->attachment_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                            <img src="{{ '/storage/' . ltrim($art->attachment_path, '/') }}" alt="{{ $art->title }}">
                        @else
                            <div style="height:100%;display:grid;place-items:center;color:rgba(255,255,255,.7);"><i data-lucide="mountain" style="width:38px;height:38px;"></i></div>
                        @endif
                    </div>
                    <div class="article-card-body">
                        <h3>{{ $art->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($art->body), 100) ?: 'Dokumentasi dan informasi kegiatan GPA.' }}</p>
                        <div class="article-meta"><span>{{ $art->created_at->translatedFormat('d F Y') }}</span><span class="article-read">Baca <i data-lucide="arrow-up-right" style="width:13px;height:13px;vertical-align:-2px;"></i></span></div>
                    </div>
                </a>
            @empty
                <div class="article-placeholder">
                    <i data-lucide="newspaper" style="width:36px;height:36px;margin-bottom:.8rem;opacity:.3;"></i>
                    <p style="font-weight:600;">Belum ada artikel kegiatan yang dipublikasikan.</p>
                    <p style="font-size:.85rem;margin-top:.3rem;">Ikuti Instagram kami untuk update kegiatan terbaru.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- INSTAGRAM SECTION -->
    <section class="ig-section reveal">
        <div class="ig-inner">
            <div class="ig-icon">
                <i data-lucide="instagram" style="width:32px;height:32px;color:#fff;"></i>
            </div>
            <h2>Ikuti Kami di Instagram</h2>
            <div class="ig-handle">@gpa_smkcbpare</div>
            <div class="ig-bio">💎 One Step For One Earth<br>📍 SMK Canda Bhirawa Pare Kediri<br>549 Followers • 240 Following</div>
            <div class="ig-highlights">
                <span class="ig-hl">Latihan Mingguan</span>
                <span class="ig-hl">Kegiatan Bersama</span>
                <span class="ig-hl">BUKBER 2026</span>
                <span class="ig-hl">RAT 2025</span>
                <span class="ig-hl">GPA Dolan</span>
                <span class="ig-hl">Bakar-Bakar</span>
                <span class="ig-hl">Fun Camp 2025</span>
                <span class="ig-hl">DIKLAT SAR Ak-25</span>
                <span class="ig-hl">GMP 2025</span>
            </div>
            <a href="https://www.instagram.com/gpa_smkcbpare" target="_blank" class="ig-btn">
                <i data-lucide="instagram" style="width:18px;height:18px;"></i>
                Follow @gpa_smkcbpare
            </a>
        </div>
    </section>

    <!-- CTA BERGABUNG -->
    <section class="cta-section reveal">
        <div class="cta-inner">
            <h2>Siap Menjadi Bagian dari GPA?</h2>
            <p>Bergabunglah bersama ratusan anggota Generasi Pencinta Alam SMK Canda Bhirawa Pare. Tempa dirimu menjadi pribadi tangguh, berkarakter, dan mencintai alam Indonesia.</p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('public.candidates.create') }}" class="cta-btn">
                    <i data-lucide="user-plus" style="width:18px;height:18px;"></i>
                    Daftar Sekarang
                </a>
                <a href="{{ route('public.check-nia') }}" class="cta-btn" style="background:rgba(255,255,255,.14);box-shadow:none;">
                    <i data-lucide="badge-check" style="width:18px;height:18px;"></i>
                    Cek Status Keanggotaan
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="pub-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <h3>GENERASI PENCINTA ALAM</h3>
                <p>Ekstrakurikuler Pencinta Alam SMK Canda Bhirawa Pare. Membentuk generasi muda yang mencintai alam, berkarakter tangguh, dan berwawasan lingkungan. Didirikan dan dibina di bawah naungan SMK Canda Bhirawa Pare, Kabupaten Kediri.</p>
                <p style="margin-top:.8rem;">
                    <i data-lucide="map-pin" style="width:13px;height:13px;display:inline;vertical-align:-2px;"></i>
                    Jl. Mayjen Mas Isman Tulungrejo, Kec. Pare, Kab. Kediri, Jawa Timur
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/gpa_smkcbpare" target="_blank" title="Instagram">
                        <i data-lucide="instagram" style="width:16px;height:16px;"></i>
                    </a>
                    <a href="https://smkcbpare.sch.id" target="_blank" title="Website Sekolah">
                        <i data-lucide="globe" style="width:16px;height:16px;"></i>
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Menu</h4>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('public.check-nia') }}">Verifikasi NIA</a>
                <a href="{{ route('public.articles') }}">Kegiatan & Artikel</a>
                <a href="{{ route('login') }}">Login Anggota</a>
            </div>
            <div class="footer-col">
                <h4>Kegiatan</h4>
                <a href="{{ route('public.articles') }}?q=DIKSAR">DIKSAR</a>
                <a href="{{ route('public.articles') }}?q=DIKLAT+SAR">DIKLAT SAR</a>
                <a href="{{ route('public.articles') }}?q=Fun+Camp">Fun Camp</a>
                <a href="{{ route('public.articles') }}?q=GMP">GMP</a>
                <a href="{{ route('public.articles') }}?q=GPA+Dolan">GPA Dolan</a>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <a href="https://www.instagram.com/gpa_smkcbpare" target="_blank">Instagram @gpa_smkcbpare</a>
                <a href="https://smkcbpare.sch.id" target="_blank">smkcbpare.sch.id</a>
                @if($settings->whatsappUrl())
                    <a href="{{ $settings->whatsappUrl() }}" target="_blank" rel="noopener">WhatsApp Pengurus</a>
                @else
                    <a href="{{ route('public.check-nia') }}">Hubungi Pengurus</a>
                @endif
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Generasi Pencinta Alam (GPA) SMK Canda Bhirawa Pare. Hak Cipta Dilindungi.
        </div>
    </footer>

    <script>
        lucide.createIcons();

        // Navbar scroll
        const navbar = document.getElementById('pubNavbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Reveal on scroll
        const revealObs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

        // Animated counter
        function animateCounters() {
            document.querySelectorAll('.stat-value[data-count]').forEach(el => {
                const target = parseInt(el.dataset.count);
                if (isNaN(target)) return;
                let current = 0;
                const inc = Math.max(1, Math.ceil(target / 50));
                const timer = setInterval(() => {
                    current += inc;
                    if (current >= target) { current = target; clearInterval(timer); }
                    el.textContent = current;
                }, 25);
            });
        }
        const statsObs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { animateCounters(); statsObs.unobserve(e.target); }
            });
        }, { threshold: 0.3 });
        const ss = document.querySelector('.stats-section');
        if (ss) statsObs.observe(ss);
    </script>
</body>
</html>
