<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat</title>
    <style>
        /* Atur halaman PDF */
        @page {
            margin: 0;
            size: auto;
        }
        body {
            margin: 0;
            padding: 0;
            /* Sans-serif agar lebih mirip font template modern */
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-size: 12pt;
        }
        .page {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .page-break {
            page-break-after: always;
        }

        /* Posisi elemen data (Nama, TTL, No HP) */
        .nama {
            position: absolute;
            top: 445px;
            left: 410px;
            font-weight: 700;
            font-size: 14pt;
            letter-spacing: 0.2px;
            z-index: 10;
        }
        .ttl {
            position: absolute;
            top: 485px;
            left: 410px;
            font-weight: 700;
            font-size: 14pt;
            letter-spacing: 0.2px;
            z-index: 10;
        }
        .no-hp {
            position: absolute;
            top: 525px;
            left: 410px;
            font-weight: 700;
            font-size: 14pt;
            letter-spacing: 0.2px;
            z-index: 10;
        }

    </style>
</head>
<body>

    {{-- HALAMAN 1 --}}
    <div class="page page-break">

        {{-- PENTING: Gunakan public_path() agar PDF Generator bisa membaca file lokal --}}
        <img src="{{ public_path('gambar/template-halaman-1.png') }}" class="background" alt="Background Halaman 1">

        {{-- Data dinamis dari Controller --}}
        <div class="nama">{{ $nama }}</div>
        <div class="ttl">{{ $tempat_tanggal_lahir }}</div>
        <div class="no-hp">{{ $no_hp }}</div>

    </div>

    {{-- HALAMAN 2 --}}
    <div class="page">

        {{-- PENTING: Gunakan public_path() di sini juga --}}
        <img src="{{ public_path('gambar/template-halaman-2.png') }}" class="background" alt="Background Halaman 2">

    </div>

</body>
</html>