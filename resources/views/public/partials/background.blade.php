<style>
    body.public-photo-page {
        background: transparent !important;
        position: relative;
        isolation: isolate;
    }
    body.public-photo-page::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background-image: linear-gradient(rgba(3, 25, 14, .68), rgba(3, 25, 14, .68)), url('{{ $siteBackgroundUrl }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        pointer-events: none;
    }
    body.public-photo-page::after {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background: rgba(248, 250, 252, .12);
        pointer-events: none;
    }
    [data-theme="dark"] body.public-photo-page::after { background: rgba(2, 6, 23, .28); }
</style>
<script>document.body.classList.add('public-photo-page');</script>
