<style>
    .pub-nav-links a.active { color: var(--green); font-weight: 700; }
    .pub-brand-icon { width: 40px; height: 40px; }
    @media (max-width: 576px) { .pub-brand-icon { width: 36px; height: 36px; } }
</style>
<nav class="pub-navbar" id="pubNavbar">
    <a href="{{ route('home') }}" class="pub-brand">
        <span class="pub-brand-icon d-inline-flex align-items-center justify-content-center flex-shrink-0 rounded-circle bg-white p-1 shadow-sm overflow-hidden"><img class="w-100 h-100 d-block rounded-circle object-fit-contain" src="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}" alt="Logo GPA"></span>
        <span>GPA SMK CB PARE</span>
    </a>
    <button class="mobile-toggle" onclick="document.querySelector('.pub-nav-links').classList.toggle('open')" aria-label="Menu">
        <i data-lucide="menu" style="width:20px;height:20px;"></i>
    </button>
    <div class="pub-nav-links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('home') }}#pilar" class="{{ request()->routeIs('home') ? '' : '' }}">Tentang</a>
        <a href="{{ route('public.check-nia') }}" class="{{ request()->routeIs('public.check-nia') ? 'active' : '' }}">Cek NIA</a>
        <a href="{{ route('public.candidates.create') }}" class="{{ request()->routeIs('public.candidates.*') ? 'active' : '' }}">Daftar Calon</a>
        <a href="{{ route('public.articles') }}" class="{{ request()->routeIs('public.articles') || request()->routeIs('public.article.show') ? 'active' : '' }}">Kegiatan</a>
        <a href="https://www.instagram.com/gpa_smkcbpare" target="_blank" rel="noopener">Instagram</a>
        @auth
            @if(auth()->user()->isAnggota())
                <a href="{{ route('login') }}" class="btn-login" style="background:var(--green-700);">Portal Anggota</a>
            @else
                <a href="{{ route('manage.dashboard') }}" class="btn-login" style="background:var(--green-700);">Panel Pengurus</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        @endauth
    </div>
</nav>
