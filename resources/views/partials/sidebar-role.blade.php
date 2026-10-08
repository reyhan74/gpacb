@php
    $user = auth()->user();
    $role = $user?->is_documentation_admin ? 'documentation' : ($user?->role ?? 'anggota');
    $navigation = config("gpa_navigation.{$role}", []);
@endphp

<div class="brand-wrapper">
    <div class="brand-logo d-flex align-items-center justify-content-center rounded-circle bg-white p-1 shadow flex-shrink-0">
        <img class="w-100 h-100 d-block object-fit-contain rounded-circle" src="{{ $siteLogoUrl }}?v={{ $siteSettings->updated_at?->timestamp ?? time() }}" alt="Logo GPA">
    </div>
    <div class="brand-info">
        <span class="brand-name">GPA SMK CB</span>
        <span class="brand-badge text-capitalize">{{ $role }}</span>
    </div>
</div>

<div class="menu-container">
    @foreach($navigation as $item)
        @if(isset($item['section']))
            <span class="menu-label">{{ $item['section'] }}</span>
        @elseif(isset($item['children']))
            @php
                $submenuActive = false;
                foreach ($item['children'] as $child) {
                    $childActive = request()->is($child['match']);
                    foreach ($child['query'] ?? [] as $key => $value) {
                        $childActive = $childActive && request()->query($key) === $value;
                    }
                    foreach ($child['exclude_query'] ?? [] as $key) {
                        $childActive = $childActive && !request()->has($key);
                    }
                    $submenuActive = $submenuActive || $childActive;
                }
            @endphp
            <button type="button" class="nav-item-custom submenu-toggle border-0 bg-transparent text-start {{ $submenuActive ? 'active' : '' }}" aria-expanded="{{ $submenuActive ? 'true' : 'false' }}">
                <i data-lucide="{{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
                <i data-lucide="chevron-down" class="submenu-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu {{ $submenuActive ? 'open' : '' }}">
                @foreach($item['children'] as $child)
                    @php
                        $childActive = request()->is($child['match']);
                        foreach ($child['query'] ?? [] as $key => $value) {
                            $childActive = $childActive && request()->query($key) === $value;
                        }
                        foreach ($child['exclude_query'] ?? [] as $key) {
                            $childActive = $childActive && !request()->has($key);
                        }
                    @endphp
                    <a href="{{ $child['url'] }}" class="nav-item-custom submenu-item {{ $childActive ? 'active' : '' }}">
                        <i data-lucide="{{ $child['icon'] }}"></i><span>{{ $child['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @else
            @php
                $isActive = request()->is($item['match']);
                foreach ($item['query'] ?? [] as $key => $value) {
                    $isActive = $isActive && request()->query($key) === $value;
                }
                foreach ($item['exclude_query'] ?? [] as $key) {
                    $isActive = $isActive && !request()->has($key);
                }
            @endphp
            <a href="{{ $item['url'] }}" class="nav-item-custom {{ $isActive ? 'active' : '' }}">
                <i data-lucide="{{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endif
    @endforeach

    <div class="nav-divider"></div>
    <a href="{{ route('home') }}" class="nav-item-custom text-info" target="_blank">
        <i data-lucide="globe"></i><span>Lihat Website</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item-custom text-danger-custom border-0 bg-transparent w-100 text-start">
            <i data-lucide="log-out"></i><span>Logout</span>
        </button>
    </form>
</div>

<style>
    .role-sidebar .brand-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 28px 22px;
        border-bottom: 1px solid rgba(255, 255, 255, .06);
    }

    .role-sidebar .brand-logo {
        width: 48px;
        height: 48px;
    }

    .role-sidebar .brand-logo img { object-position: center; }
    .role-sidebar .brand-info { min-width: 0; }
    .role-sidebar .brand-name { display: block; color: #fff; font-weight: 800; font-size: 1.05rem; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; letter-spacing: -0.3px; }
    .role-sidebar .brand-badge { display: block; color: #4ade80; font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; margin-top: 4px; }
    .role-sidebar .menu-container { height: calc(100vh - 100px); overflow-y: auto; padding: 22px 14px; }
    .role-sidebar .menu-label { display: block; color: #64748b; font-size: .65rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; margin: 18px 10px 8px; }
    .role-sidebar .menu-label:first-child { margin-top: 0; }
    .role-sidebar .nav-item-custom { display: flex; align-items: center; gap: 12px; width: 100%; padding: 11px 12px; margin: 3px 0; border-radius: 11px; color: #94a3b8; text-decoration: none; font-size: .82rem; font-weight: 600; transition: .2s ease; cursor: pointer; }
    .role-sidebar .nav-item-custom:hover, .role-sidebar .nav-item-custom.active { color: #fff; background: rgba(22, 101, 52, 0.25); }
    .role-sidebar .nav-item-custom.active { box-shadow: inset 3px 0 #22c55e; color: #4ade80; }
    .role-sidebar .nav-item-custom svg { width: 18px; height: 18px; flex: 0 0 auto; }
    .role-sidebar.collapsed .brand-info,
    .role-sidebar.collapsed .nav-item-custom span,
    .role-sidebar.collapsed .menu-label { display: none; }
    .role-sidebar.collapsed .brand-wrapper { justify-content: center; padding: 24px 12px; }
    .role-sidebar.collapsed .menu-container { padding-left: 12px; padding-right: 12px; }
    .role-sidebar.collapsed .nav-item-custom { justify-content: center; padding-left: 11px; padding-right: 11px; }
    .role-sidebar.collapsed .nav-item-custom.active { box-shadow: none; }
    .role-sidebar.collapsed .submenu-toggle .submenu-chevron { display: none; }
    .role-sidebar.collapsed .sidebar-submenu { padding-left: 0; }
    .role-sidebar.collapsed .nav-divider { margin-left: 4px; margin-right: 4px; }
    .role-sidebar .submenu-toggle { cursor: pointer; }
    .role-sidebar .submenu-chevron { transition: transform .2s ease; }
    .role-sidebar .submenu-toggle[aria-expanded="true"] .submenu-chevron { transform: rotate(180deg); }
    .role-sidebar .sidebar-submenu { display: none; padding-left: 14px; }
    .role-sidebar .sidebar-submenu.open { display: block; }
    .role-sidebar .submenu-item { font-size: .78rem; padding-top: 9px; padding-bottom: 9px; }
    .role-sidebar .nav-divider { height: 1px; margin: 18px 10px; background: rgba(255, 255, 255, .08); }
    .role-sidebar .text-danger-custom { color: #f87171; }
    .role-sidebar .text-danger-custom:hover { color: #ef4444; background: rgba(239, 68, 68, 0.15); }
    .role-sidebar .text-info { color: #38bdf8 !important; }
    .role-sidebar .text-info:hover { color: #7dd3fc !important; background: rgba(56, 189, 248, 0.12); }
    .role-sidebar form { margin: 0; }
    @media (max-width: 991.98px) { .role-sidebar .menu-container { height: calc(100vh - 94px); } }
</style>

<script>
    document.querySelectorAll('.role-sidebar .submenu-toggle').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const submenu = toggle.nextElementSibling;
            const isOpen = submenu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });
</script>
