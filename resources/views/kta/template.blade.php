<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTA {{ $member->nia }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0px;
            padding: 0px;
            background-color: #f1f5f9;
            color: #0f172a;
            -webkit-print-color-adjust: exact;
        }
        .card-container {
            width: 242.64pt;  /* 85.6mm */
            height: 152.99pt; /* 53.98mm */
            position: relative;
            background: #ffffff;
            overflow: hidden;
            border-radius: 6pt;
        }
        .header-band {
            background-color: #ea580c; /* Orange branding khas KTA */
            height: 34pt;
            padding: 2pt 6pt;
            color: #ffffff;
            position: relative;
        }
        .header-title {
            font-size: 7.5pt;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5pt;
            line-height: 9pt;
            margin-top: 2pt;
        }
        .header-sub {
            font-size: 5.5pt;
            text-align: center;
            color: #ffedd5;
            line-height: 7pt;
        }
        .header-address {
            font-size: 4.5pt;
            text-align: center;
            color: #fed7aa;
            margin-top: 1pt;
        }
        .content-body {
            padding: 6pt 8pt;
            position: relative;
        }
        .photo-box {
            position: absolute;
            left: 8pt;
            top: 42pt;
            width: 52pt;
            height: 68pt;
            border: 1pt solid #cbd5e1;
            background: #581c87; /* Purple backdrop khas foto KTA */
            border-radius: 3pt;
            overflow: hidden;
            text-align: center;
        }
        .photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .data-table {
            position: absolute;
            left: 66pt;
            top: 38pt;
            width: 168pt;
            font-size: 5.2pt;
            line-height: 7.2pt;
            border-collapse: collapse;
        }
        .data-table td {
            vertical-align: top;
            padding: 0.6pt 1pt;
        }
        .label-col {
            width: 58pt;
            color: #334155;
            font-weight: bold;
        }
        .sep-col {
            width: 4pt;
            text-align: center;
        }
        .val-col {
            color: #0f172a;
            font-weight: 600;
        }
        .signature-section {
            position: absolute;
            right: 8pt;
            bottom: 4pt;
            text-align: center;
            font-size: 4.8pt;
            line-height: 6pt;
            width: 85pt;
        }
        .sign-title {
            color: #475569;
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
            color: #0f172a;
            margin-top: 16pt;
        }
    </style>
</head>
<body>
    <div class="card-container">
        {{-- HEADER --}}
        <div class="header-band">
            <div class="header-title">KARTU TANDA ANGGOTA</div>
            <div class="header-sub">GENERASI PECINTA ALAM SMK CANDA BHIRAWA PARE</div>
            <div class="header-address">Jl. Mayjen Mas Isman Tulungrejo • website: https://smkcbpare.sch.id Pare - Kediri</div>
        </div>

        {{-- FOTO PEMEGANG KTA --}}
        <div class="photo-box">
            @if($photoBase64)
                <img src="{{ $photoBase64 }}" class="photo-img">
            @else
                <div style="color: #ffffff; font-size: 6pt; margin-top: 25pt; font-weight: bold;">FOTO<br>3x4</div>
            @endif
        </div>

        {{-- TABEL IDENTITAS --}}
        <table class="data-table">
            <tr>
                <td class="label-col">Nama</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ strtoupper($member->nama) }}</td>
            </tr>
            <tr>
                <td class="label-col">Nama Lapangan</td>
                <td class="sep-col">:</td>
                <td class="val-col" style="color: #c2410c;">"{{ $member->nama_lapangan ?: '-' }}"</td>
            </tr>
            <tr>
                <td class="label-col">N.I.A.</td>
                <td class="sep-col">:</td>
                <td class="val-col" style="font-weight: bold; color: #1e3a8a;">{{ $member->nia }}</td>
            </tr>
            <tr>
                <td class="label-col">NIS</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $member->nis ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tempat Tgl Lahir</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $member->ttl_raw ?: ($member->tempat_lahir . ', ' . ($member->tanggal_lahir ? $member->tanggal_lahir->translatedFormat('d F Y') : '-')) }}</td>
            </tr>
            <tr>
                <td class="label-col">Jenis Kelamin</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $member->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td class="label-col">No. Hp</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $member->no_hp ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Agama</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ $member->agama }}</td>
            </tr>
            <tr>
                <td class="label-col">Alamat</td>
                <td class="sep-col">:</td>
                <td class="val-col">{{ \Illuminate\Support\Str::limit($member->alamat ?: '-', 45) }}</td>
            </tr>
        </table>

        {{-- PENGESAHAN PEMBINA --}}
        <div class="signature-section">
            <div class="sign-title">Pare, {{ ($member->tanggal_pengesahan ?? now())->translatedFormat('d F Y') }}</div>
            <div class="sign-title">{{ $member->pembina_jabatan ?: 'Pembina GPA SMK CB' }}</div>
            <div class="sign-name">{{ $member->pembina_nama ?: 'RICKY HIDAYAT, S.Pd' }}</div>
        </div>
    </div>
</body>
</html>
