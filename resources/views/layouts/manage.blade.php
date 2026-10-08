<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Manajemen GPA' }}</title>
    <style>
        :root { --green:#176b45; --green-dark:#104b30; --paper:#f4f7f5; --ink:#15231b; }
        * { box-sizing:border-box; }
        body { font-family:system-ui,-apple-system,sans-serif; background:var(--paper); color:var(--ink); margin:0; }
        .layout { display:flex; min-height:100vh; }
        .sidebar { width:245px; flex:0 0 245px; background:var(--green-dark); color:#fff; padding:1.5rem 1rem; display:flex; flex-direction:column; }
        .brand { font-weight:800; line-height:1.2; padding:.5rem .75rem 1.8rem; font-size:1.05rem; }
        .nav-link { color:#e9f4ec; text-decoration:none; border-radius:8px; padding:.8rem .75rem; display:block; margin:.2rem 0; }
        .nav-link:hover, .nav-link.active { background:#2b7c56; color:#fff; }
        .sidebar footer { margin-top:auto; padding:.75rem; font-size:.85rem; color:#b7d8c1; }
        .logout { background:transparent; color:#fff; border:1px solid #7fb593; border-radius:8px; padding:.55rem .7rem; width:100%; cursor:pointer; }
        .page { flex:1; min-width:0; padding:2rem; }
        .page-inner { max-width:1000px; margin:0 auto; }
        .cards { display:flex; gap:1rem; flex-wrap:wrap; }
        .card,.box { background:#fff; border-radius:12px; padding:1.2rem; box-shadow:0 4px 14px #1231; }
        .card { min-width:180px; }
        .button { display:inline-block; background:var(--green); color:#fff; padding:.7rem 1rem; border-radius:8px; text-decoration:none; border:0; cursor:pointer; }
        input, textarea, select { width:100%; box-sizing:border-box; padding:.7rem; margin:.3rem 0 1rem; border:1px solid #ccd5ce; border-radius:8px; font:inherit; }
        table { width:100%; border-collapse:collapse; background:#fff; } th,td { padding:.8rem; text-align:left; border-bottom:1px solid #ddd; }
        a { color:var(--green); } .sidebar a { color:#e9f4ec; } .notice { background:#ddf4e4; color:#104b30; padding:.75rem; border-radius:8px; }
        @media(max-width:700px) { .layout{display:block}.sidebar{width:auto; min-height:auto}.sidebar nav{display:flex;gap:.3rem;flex-wrap:wrap}.sidebar footer{margin-top:1rem}.page{padding:1rem} }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">Generasi<br>Pencinta Alam</div>
        <nav>
            <a class="nav-link {{ request()->routeIs('manage.dashboard') ? 'active' : '' }}" href="{{ route('manage.dashboard') }}">Dashboard</a>
            <a class="nav-link {{ request()->routeIs('manage.members.*') ? 'active' : '' }}" href="{{ route('manage.members.index') }}">Data Anggota & NIA</a>
            <a class="nav-link {{ request()->routeIs('manage.contents.*') ? 'active' : '' }}" href="{{ route('manage.contents.index') }}">Artikel & Kegiatan</a>
            @if(auth()->user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('manage.users') ? 'active' : '' }}" href="{{ route('manage.users') }}">Akun Pengguna</a>
                <a class="nav-link {{ request()->routeIs('manage.settings.*') ? 'active' : '' }}" href="{{ route('manage.settings.edit') }}">Pengaturan Web</a>
            @endif
            <a class="nav-link" href="{{ route('home') }}" target="_blank">Lihat Website ↗</a>
        </nav>
        <footer>
            <div>{{ auth()->user()->name }}</div>
            <div>{{ ucfirst(auth()->user()->role) }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:1rem">@csrf<button class="logout">Keluar</button></form>
        </footer>
    </aside>
    <main class="page"><div class="page-inner">{{ $slot }}</div></main>
</div>
</body>
</html>
