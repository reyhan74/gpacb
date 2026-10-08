<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->site_name }}{{ $settings->school_name ? ' | '.$settings->school_name : '' }}</title>
    <meta name="description" content="Landing page ekstrakurikuler Generasi Pencinta Alam SMK Canda Bhirawa Pare — belajar, bertualang, dan menumbuhkan kepedulian terhadap lingkungan.">
    <style>
        :root {
            --forest-950: #0f1f17;
            --forest-900: #163126;
            --forest-800: #224734;
            --forest-700: #2f6046;
            --forest-600: #3a7657;
            --moss-500: #7b9b6f;
            --moss-300: #adc49e;
            --sand-100: #f4f0e6;
            --sand-200: #e9dfcf;
            --earth-500: #8c6a4a;
            --ink: #132019;
            --muted: #5e6f64;
            --white: #ffffff;
            --line: rgba(19, 32, 25, 0.1);
            --shadow: 0 20px 60px rgba(9, 18, 13, 0.18);
            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 14px;
            --max: 1180px;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(173, 196, 158, 0.28), transparent 32%),
                linear-gradient(180deg, #f8f5ef 0%, #eef2e7 54%, #f8f5ef 100%);
            line-height: 1.6;
        }

        img { max-width: 100%; display: block; }
        a { color: inherit; text-decoration: none; }
        .container { width: min(var(--max), calc(100% - 32px)); margin: 0 auto; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(14px);
            background: rgba(248, 245, 239, 0.72);
            border-bottom: 1px solid rgba(19, 32, 25, 0.08);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 16px 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            letter-spacing: 0.02em;
            min-width: 0;
        }

        .brand > div:last-child {
            min-width: 0;
        }

        .brand-mark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            overflow: hidden;
            flex: 0 0 56px;
            background: var(--white);
            border: 2px solid rgba(19, 32, 25, 0.10);
            box-shadow: var(--shadow);
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-title {
            font-size: 1rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .brand-subtitle {
            color: var(--muted);
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            display: block;
            margin-top: 4px;
            line-height: 1.2;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            color: var(--muted);
            font-size: 0.96rem;
        }

        .nav-actions { display: flex; align-items: center; }
        .nav-login {
            min-height: 40px;
            padding: 9px 16px;
            background: var(--forest-800);
            color: var(--white);
            font-size: 0.92rem;
        }

        .menu-toggle {
            display: none;
            width: 48px;
            height: 48px;
            border: 1px solid rgba(19, 32, 25, 0.12);
            border-radius: 14px;
            background: rgba(255,255,255,0.82);
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(9, 18, 13, 0.08);
        }

        .menu-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--forest-900);
            border-radius: 999px;
            transition: transform .25s ease, opacity .25s ease;
        }

        .menu-toggle-inner {
            display: grid;
            gap: 4px;
        }

        .menu-toggle[aria-expanded="true"] .menu-toggle-inner span:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }

        .menu-toggle[aria-expanded="true"] .menu-toggle-inner span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle[aria-expanded="true"] .menu-toggle-inner span:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }

        .hero {
            padding: 56px 0 36px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 28px;
            align-items: stretch;
        }

        .hero-copy,
        .hero-visual,
        .card,
        .gallery-card,
        .contact-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
        }

        .hero-copy {
            padding: 42px;
            background:
                linear-gradient(160deg, rgba(22, 49, 38, 0.96), rgba(34, 71, 52, 0.92)),
                linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0));
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .hero-copy::after {
            content: "";
            position: absolute;
            inset: auto -80px -120px auto;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(173, 196, 158, 0.28), transparent 68%);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.12);
            font-size: 0.88rem;
            margin-bottom: 18px;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.5rem, 5vw, 4.9rem);
            line-height: 0.98;
            letter-spacing: -0.04em;
            max-width: 9ch;
            text-wrap: pretty;
        }

        .hero-copy p {
            margin: 18px 0 0;
            max-width: 58ch;
            color: rgba(255,255,255,0.84);
            font-size: 1.04rem;
        }

        .cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 28px;
        }

        .btn {
            min-height: 46px;
            padding: 12px 20px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: transform .2s ease, background .2s ease, color .2s ease, border-color .2s ease;
            border: 1px solid transparent;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: var(--sand-100); color: var(--forest-900); }
        .btn-secondary { border-color: rgba(255,255,255,0.22); color: var(--white); background: rgba(255,255,255,0.05); }

        .hero-stats {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .hero-stats div {
            padding: 14px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .hero-stats strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .hero-visual {
            padding: 20px;
            background: linear-gradient(180deg, #dfe9d8 0%, #becfb7 100%);
            position: relative;
            overflow: hidden;
            min-height: 100%;
        }

        .visual-frame {
            height: 100%;
            min-height: 520px;
            border-radius: 24px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(180deg, rgba(15, 31, 23, 0.10), rgba(15, 31, 23, 0.02)),
                url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80') center/cover;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .visual-frame::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(7, 18, 12, 0.12), rgba(7, 18, 12, 0.72));
        }

        .visual-frame > * { position: relative; z-index: 1; }

        .visual-chip {
            width: fit-content;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.14);
            border: 1px solid rgba(255,255,255,0.18);
            backdrop-filter: blur(10px);
            font-size: 0.88rem;
        }

        .visual-quote {
            max-width: 26ch;
            font-size: clamp(1.3rem, 3vw, 2rem);
            line-height: 1.15;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        section {
            padding: 34px 0;
        }

        .section-heading {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 24px;
            margin-bottom: 24px;
            align-items: start;
        }

        .kicker {
            color: var(--forest-700);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.78rem;
            margin-bottom: 10px;
        }

        h2 {
            margin: 0;
            font-size: clamp(1.8rem, 3.2vw, 3rem);
            line-height: 1.06;
            letter-spacing: -0.03em;
            text-wrap: pretty;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .about-panel {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 20px;
        }

        .card {
            background: rgba(255,255,255,0.72);
            padding: 28px;
        }

        .about-values {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 18px;
        }

        .mini-box {
            padding: 16px;
            border-radius: 16px;
            background: var(--sand-100);
            border: 1px solid rgba(19, 32, 25, 0.08);
        }

        .mini-box strong {
            display: block;
            margin-bottom: 4px;
        }

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .activity-card {
            background: rgba(255,255,255,0.72);
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .activity-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 800;
            color: var(--forest-900);
            background: var(--moss-300);
            margin-bottom: 16px;
        }

        .activity-card h3,
        .gallery-card h3,
        .contact-card h3 {
            margin: 0 0 8px;
            font-size: 1.18rem;
            letter-spacing: -0.02em;
        }

        .activity-card p,
        .gallery-card p,
        .contact-card p,
        .card p,
        .card li {
            margin: 0;
            color: var(--muted);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr 0.9fr;
            gap: 18px;
        }

        .gallery-card {
            min-height: 260px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: var(--white);
            position: relative;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }

        .gallery-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(8, 18, 13, 0.10), rgba(8, 18, 13, 0.82));
        }

        .gallery-card > * { position: relative; z-index: 1; }
        .gallery-card p { color: rgba(255,255,255,0.82); }

        .instagram-section {
            padding: 10px 0 34px;
        }

        .instagram-panel {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 20px;
            padding: 30px;
            border-radius: var(--radius-xl);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            background: linear-gradient(135deg, rgba(22,49,38,0.97), rgba(31,64,48,0.94));
            color: var(--white);
            overflow: hidden;
            position: relative;
        }

        .instagram-panel::after {
            content: "";
            position: absolute;
            right: -80px;
            bottom: -90px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(188, 45, 80, 0.34), transparent 70%);
        }

        .instagram-panel > * {
            position: relative;
            z-index: 1;
        }

        .instagram-copy p,
        .instagram-card p {
            color: rgba(255,255,255,0.82);
            margin: 0;
        }

        .instagram-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 22px;
        }

        .btn-instagram {
            background: #ffffff;
            color: #163126;
        }

        .btn-outline-light {
            background: rgba(255,255,255,0.06);
            color: #ffffff;
            border-color: rgba(255,255,255,0.18);
        }

        .instagram-card {
            padding: 22px;
            border-radius: 22px;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
        }

        .instagram-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 18px;
        }

        .instagram-stats div {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.10);
            text-align: center;
        }

        .instagram-stats strong {
            display: block;
            font-size: 1.15rem;
            margin-bottom: 4px;
        }

        .contact-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .contact-card {
            background: rgba(255,255,255,0.74);
            padding: 28px;
        }

        .contact-list {
            display: grid;
            gap: 14px;
            margin-top: 18px;
        }

        .contact-item {
            padding: 14px 16px;
            border-radius: 16px;
            background: var(--sand-100);
            border: 1px solid rgba(19, 32, 25, 0.08);
        }

        .contact-item span {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 2px;
        }

        footer {
            padding: 28px 0 44px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        @media (max-width: 980px) {
            .container {
                width: min(var(--max), calc(100% - 24px));
            }

            .hero {
                padding: 36px 0 28px;
            }

            .hero-grid,
            .section-heading,
            .about-panel,
            .contact-wrap,
            .gallery-grid,
            .activity-grid,
            .instagram-panel {
                grid-template-columns: 1fr;
            }

            .hero-copy,
            .hero-visual,
            .card,
            .contact-card,
            .activity-card,
            .instagram-panel {
                border-radius: 24px;
            }

            .hero-copy {
                padding: 32px;
            }

            .hero-stats,
            .instagram-stats {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .visual-frame {
                min-height: 380px;
            }

            .nav-links {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 720px) {
            .topbar {
                position: static;
            }

            .nav {
                display: grid;
                grid-template-columns: 1fr auto;
                align-items: center;
                gap: 14px;
            }

            .brand {
                align-items: center;
            }

            .brand-mark {
                width: 50px;
                height: 50px;
                flex-basis: 50px;
            }

            .brand-title {
                font-size: 0.92rem;
                letter-spacing: 0.06em;
            }

            .brand-subtitle {
                font-size: 0.76rem;
                letter-spacing: 0.03em;
            }

            .menu-toggle {
                display: inline-flex;
            }

            .nav-links {
                width: 100%;
                display: none;
                grid-column: 1 / -1;
                grid-template-columns: 1fr;
                gap: 10px;
                padding-top: 6px;
            }

            .nav-links.is-open {
                display: grid;
            }

            .nav-links a {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 44px;
                padding: 10px 12px;
                border: 1px solid rgba(19, 32, 25, 0.1);
                border-radius: 999px;
                background: rgba(255,255,255,0.6);
            }

            .hero-copy,
            .card,
            .contact-card,
            .activity-card,
            .instagram-panel,
            .instagram-card {
                padding: 22px;
            }

            .hero-visual {
                padding: 14px;
            }

            .visual-frame {
                min-height: 300px;
                padding: 18px;
            }

            .eyebrow {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            h1 {
                max-width: 100%;
                font-size: clamp(2rem, 10vw, 3rem);
            }

            h2 {
                font-size: clamp(1.5rem, 7vw, 2.25rem);
            }

            .hero-copy p,
            .section-heading p,
            .instagram-copy p,
            .instagram-card p {
                font-size: 0.96rem;
            }

            .cta-row,
            .instagram-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .hero-stats,
            .about-values,
            .instagram-stats,
            .nav-links {
                grid-template-columns: 1fr;
            }

            .gallery-card {
                min-height: 220px;
            }

            section {
                padding: 26px 0;
            }
        }

        @media (max-width: 420px) {
            .container {
                width: min(var(--max), calc(100% - 18px));
            }

            .hero-copy,
            .card,
            .contact-card,
            .activity-card,
            .instagram-panel,
            .instagram-card {
                padding: 18px;
            }

            .hero-stats div,
            .instagram-stats div,
            .contact-item,
            .mini-box {
                padding: 12px 14px;
            }

            .visual-quote {
                font-size: 1.2rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .btn { transition: none; }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="container nav">
            <div class="brand">
                <div class="brand-mark">
                    <img src="{{ asset('assets/logo-gpa.jpg') }}" alt="Logo Generasi Pecinta Alam">
                </div>
                <div>
                    <div class="brand-title">{{ $settings->site_name }}</div>
                    @if($settings->school_name)<small class="brand-subtitle">{{ $settings->school_name }}</small>@endif
                </div>
            </div>
            <button class="menu-toggle" id="menuToggle" type="button" aria-expanded="false" aria-controls="mobileNav" aria-label="Buka menu navigasi">
                <span class="menu-toggle-inner">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
            <div class="nav-links" id="mobileNav">
                <a href="#tentang">Tentang</a>
                <a href="#kegiatan">Kegiatan</a>
                <a href="#galeri">Galeri</a>
                <a href="#instagram">Instagram</a>
                <a href="#kontak">Kontak</a>
            </div>
            <div class="nav-actions">
                <a class="btn nav-login" href="{{ route('login') }}">Masuk Pengelola</a>
            </div>
        </div>
    </div>

    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div class="hero-copy">
                    <div class="eyebrow">• One Step For One Earth</div>
                    <h1>GENERASI PENCINTA ALAM</h1>
                    <p style="margin-top:10px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color: rgba(255,255,255,0.72);">
                        SMK CANDA BHIRAWA PARE
                    </p>
                    <p>
                        Bukan sekadar teori. Di sini kami belajar mengenal alam lebih dekat, melatih keterampilan,
                        membangun kerja sama, dan menumbuhkan kepedulian terhadap lingkungan melalui pengalaman nyata.
                    </p>
                    <div class="cta-row">
                        <a class="btn btn-primary" href="#kegiatan">Jelajahi Kegiatan</a>
                        @if($settings->instagram_url)<a class="btn btn-secondary" href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer">Kunjungi Instagram</a>@endif
                        @if($settings->whatsappUrl())<a class="btn btn-secondary" href="{{ $settings->whatsappUrl() }}" target="_blank" rel="noopener noreferrer">Hubungi WhatsApp</a>@endif
                    </div>
                    <div class="hero-stats">
                        <div>
                            <strong>Belajar</strong>
                            <span>Memahami alam dan lingkungan secara nyata.</span>
                        </div>
                        <div>
                            <strong>Bertualang</strong>
                            <span>Membangun keberanian, disiplin, dan kerja sama.</span>
                        </div>
                        <div>
                            <strong>Peduli</strong>
                            <span>Menjaga alam lewat aksi sederhana yang berdampak.</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="visual-frame">
                        <div class="visual-chip">@gpa_smkcbpare • One Step For One Earth</div>
                        <div class="visual-quote">“Melatih keterampilan, kesiapan, dan kerja sama untuk menghadapi setiap kondisi.”</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <div class="kicker">Tentang Kami</div>
                        <h2>Tempat tumbuh bagi siswa yang menyukai alam dan kebersamaan.</h2>
                    </div>
                    <p>
                        Generasi Pecinta Alam hadir sebagai ruang belajar nonformal yang membentuk sikap peduli,
                        disiplin, dan bertanggung jawab. Melalui kegiatan luar ruang dan aksi lingkungan, anggota tidak
                        hanya mengenal alam, tetapi juga belajar menjadi bagian yang menjaganya.
                    </p>
                </div>

                <div class="about-panel">
                    <div class="card">
                        <h3 style="margin-top:0; font-size:1.3rem; letter-spacing:-0.02em;">Nilai yang kami pegang</h3>
                        <p>
                            Kami percaya bahwa pengalaman langsung di alam mampu menumbuhkan keberanian, empati,
                            dan rasa tanggung jawab yang kuat. Karena itu, setiap kegiatan dirancang bukan hanya seru,
                            tetapi juga mendidik.
                        </p>
                        <div class="about-values">
                            <div class="mini-box">
                                <strong>Cinta Alam</strong>
                                Menjaga lingkungan sebagai bagian dari gaya hidup sehari-hari.
                            </div>
                            <div class="mini-box">
                                <strong>Kebersamaan</strong>
                                Tumbuh bersama melalui kerja tim dan saling dukung.
                            </div>
                            <div class="mini-box">
                                <strong>Disiplin</strong>
                                Membiasakan tanggung jawab dalam setiap kegiatan.
                            </div>
                            <div class="mini-box">
                                <strong>Karakter Tangguh</strong>
                                Belajar mandiri, tenang, dan siap menghadapi tantangan.
                            </div>
                        </div>
                    </div>

                    <div class="card" style="background: linear-gradient(180deg, #f4f0e6 0%, #e6eedf 100%);">
                        <div class="kicker" style="margin-bottom:12px;">Tujuan</div>
                        <h3 style="margin:0 0 10px; font-size:1.5rem; letter-spacing:-0.03em;">Mengenal alam lebih dekat, lalu menjaganya dengan kesadaran.</h3>
                        <ul style="margin: 0; padding-left: 18px; display:grid; gap:10px;">
                            <li>Membentuk siswa yang peduli lingkungan dan aktif berkontribusi.</li>
                            <li>Mendorong keberanian, kepemimpinan, dan kerja sama tim.</li>
                            <li>Menjadi wadah positif untuk belajar di luar kelas dengan cara yang menyenangkan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="kegiatan">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <div class="kicker">Kegiatan Utama</div>
                        <h2>Aktivitas yang menyatukan petualangan, pendidikan, dan kepedulian.</h2>
                    </div>
                    <p>
                        Program kegiatan bisa disesuaikan dengan agenda sekolah, namun secara umum berfokus pada
                        pembelajaran alam, kerja sama tim, dan aksi nyata untuk lingkungan sekitar.
                    </p>
                </div>

                <div class="activity-grid">
                    <article class="activity-card">
                        <div class="activity-number">01</div>
                        <h3>Jelajah Alam</h3>
                        <p>Mengenal lingkungan sekitar melalui observasi, perjalanan ringan, dan pembelajaran langsung di lapangan.</p>
                    </article>
                    <article class="activity-card">
                        <div class="activity-number">02</div>
                        <h3>Kemah & Survival Dasar</h3>
                        <p>Melatih kemandirian, kedisiplinan, dan kemampuan dasar bertahan di alam secara aman dan terarah.</p>
                    </article>
                    <article class="activity-card">
                        <div class="activity-number">03</div>
                        <h3>Aksi Peduli Lingkungan</h3>
                        <p>Kegiatan bersih lingkungan, penanaman pohon, dan kampanye sederhana untuk meningkatkan kesadaran.</p>
                    </article>
                    <article class="activity-card">
                        <div class="activity-number">04</div>
                        <h3>Edukasi Konservasi</h3>
                        <p>Belajar tentang ekosistem, pelestarian alam, dan pentingnya menjaga keseimbangan lingkungan.</p>
                    </article>
                    <article class="activity-card">
                        <div class="activity-number">05</div>
                        <h3>Latihan Kerja Tim</h3>
                        <p>Permainan dan simulasi yang membangun komunikasi, kepemimpinan, dan rasa saling percaya.</p>
                    </article>
                    <article class="activity-card">
                        <div class="activity-number">06</div>
                        <h3>Dokumentasi Kegiatan</h3>
                        <p>Merekam perjalanan, pengalaman, dan pembelajaran agar menjadi inspirasi bagi anggota berikutnya.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="galeri">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <div class="kicker">Galeri</div>
                        <h2>Momen yang menggambarkan semangat petualangan dan kepedulian.</h2>
                    </div>
                    <p>
                        Bagian ini dapat diisi dokumentasi kegiatan sekolah seperti camping, bakti lingkungan,
                        penjelajahan, atau kegiatan edukasi alam lainnya.
                    </p>
                </div>

                <div class="gallery-grid">
                    <article class="gallery-card" style="background-image:url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80');">
                        <h3>Jelajah & Observasi</h3>
                        <p>Belajar dari alam dengan melihat, mencatat, dan memahami langsung lingkungan sekitar.</p>
                    </article>
                    <article class="gallery-card" style="background-image:url('https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=1200&q=80');">
                        <h3>Kebersamaan Tim</h3>
                        <p>Membangun solidaritas dan semangat saling mendukung dalam setiap langkah.</p>
                    </article>
                    <article class="gallery-card" style="background-image:url('https://images.unsplash.com/photo-1470770903676-69b98201ea1c?auto=format&fit=crop&w=1200&q=80');">
                        <h3>Peduli Lingkungan</h3>
                        <p>Aksi sederhana yang menunjukkan bahwa kepedulian dimulai dari sekitar kita.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="instagram-section" id="instagram">
            <div class="container">
                <div class="instagram-panel">
                    <div class="instagram-copy">
                        <div class="kicker" style="color: rgba(255,255,255,0.72);">Instagram Resmi</div>
                        <h2 style="color: var(--white);">Ikuti aktivitas GENERASI PENCINTA ALAM di Instagram.</h2>
                        <p style="margin-top: 12px; max-width: 58ch;">
                            Untuk melihat dokumentasi kegiatan, semangat kebersamaan, dan suasana lapangan secara langsung,
                            kunjungi akun resmi kami di Instagram.
                        </p>
                        <div class="instagram-actions">
                            <a class="btn btn-instagram" href="https://www.instagram.com/gpa_smkcbpare/" target="_blank" rel="noopener noreferrer">Follow @gpa_smkcbpare</a>
                            <a class="btn btn-outline-light" href="#galeri">Lihat Galeri Website</a>
                        </div>
                    </div>
                    <div class="instagram-card">
                        <h3 style="margin-top:0; color: var(--white);">@gpa_smkcbpare</h3>
                        <p>One Step For One Earth</p>
                        <div class="instagram-stats">
                            <div>
                                <strong>127</strong>
                                <span>Posts</span>
                            </div>
                            <div>
                                <strong>551</strong>
                                <span>Followers</span>
                            </div>
                            <div>
                                <strong>241</strong>
                                <span>Following</span>
                            </div>
                        </div>
                        <p style="margin-top:18px;">
                            Profil publik menunjukkan identitas kuat sebagai ekskul pecinta alam sekolah dengan tone konten
                            yang aktif, tangguh, dan berorientasi aksi nyata.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <div class="kicker">Kontak</div>
                        <h2>Ingin mengenal lebih dekat Generasi Pecinta Alam?</h2>
                    </div>
                    <p>
                        Kamu bisa mengganti bagian ini dengan data sekolah, pembina, pengurus, dan kanal komunikasi resmi.
                        Saya sengaja menyiapkan format yang mudah diedit nanti.
                    </p>
                </div>

                <div class="contact-wrap">
                    <div class="contact-card">
                        <h3>Informasi Utama</h3>
                        <p>Silakan sesuaikan data berikut dengan informasi resmi ekstrakurikuler atau sekolah.</p>
                        <div class="contact-list">
                            <div class="contact-item">
                                <span>Nama Sekolah</span>
                                SMK CANDA BHIRAWA PARE
                            </div>
                            <div class="contact-item">
                                <span>Pembina</span>
                                RICKY HIDAYAT
                            </div>
                            <div class="contact-item">
                                <span>Alamat</span>
                                Pare, Kediri
                            </div>
                        </div>
                    </div>

                    <div class="contact-card">
                        <h3>Hubungi Kami</h3>
                        <p>Gunakan bagian ini untuk memudahkan siswa, guru, atau orang tua mendapatkan informasi lebih lanjut.</p>
                        <div class="contact-list">
                            <div class="contact-item">
                                <span>Instagram</span>
                                <a href="https://www.instagram.com/gpa_smkcbpare/" target="_blank" rel="noopener noreferrer">@gpa_smkcbpare</a>
                            </div>
                            <div class="contact-item">
                                <span>Email</span>
                                @if($settings->email)<a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>@else Belum diatur @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            © {{ date('Y') }} Generasi Pecinta Alam — belajar, bertualang, dan menjaga alam bersama.
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileNav = document.getElementById('mobileNav');

        if (menuToggle && mobileNav) {
            const closeMenu = () => {
                menuToggle.setAttribute('aria-expanded', 'false');
                mobileNav.classList.remove('is-open');
            };

            menuToggle.addEventListener('click', () => {
                const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
                menuToggle.setAttribute('aria-expanded', String(!isOpen));
                mobileNav.classList.toggle('is-open', !isOpen);
            });

            mobileNav.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', closeMenu);
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 720) {
                    closeMenu();
                }
            });
        }
    </script>
</body>
</html>
