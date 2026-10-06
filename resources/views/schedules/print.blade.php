@php
    \Carbon\Carbon::setLocale('id');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak / PDF - Jadwal Sidang PPS BPN Subang</title>
    <style>
        :root {
            --primary: #0c2340;
            --primary-hover: #162e4d;
            --accent: #fbc02d;
            --text: #1e293b;
            --border: #cbd5e1;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            color: var(--text); 
            background-color: #f8fafc;
            font-size: 12px; 
            line-height: 1.5; 
        }

        /* Container Dokumen (Efek Kertas A4) */
        .page-container {
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border);
        }

        /* Header Kop Surat Resmi ATR/BPN Subang */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 8px;
            text-align: center;
        }

        .kop-logo img {
            width: 85px;
            height: auto;
        }

        .kop-teks h2 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 15pt;
            font-weight: bold;
            color: #000;
            margin: 0;
            line-height: 1.25;
            text-transform: uppercase;
        }

        .kop-teks h3 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13pt;
            font-weight: bold;
            color: #000;
            margin: 4px 0 0 0;
            text-transform: uppercase;
        }

        .kop-teks h4 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            font-weight: bold;
            color: #000;
            margin: 2px 0 0 0;
            text-transform: uppercase;
        }

        /* Garis Pembatas Kop Surat ganda khas instansi pemerintah */
        .kop-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        /* Judul Sub Laporan */
        .doc-subheading {
            text-align: center;
            margin-bottom: 20px;
        }
        .doc-subheading h4 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
        }
        .doc-subheading p {
            font-size: 11px;
            color: #334155;
            margin-top: 3px;
        }

        /* Action Bar Floating Button */
        .action-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
            background: #ffffff;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-secondary { background: #64748b; color: #fff; }
        .btn-secondary:hover { background: #475569; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px 10px; text-align: left; vertical-align: top; }
        th { background: #f1f5f9; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 11px; color: #000; }
        .text-center { text-align: center; }

        /* Legalisasi / Tanda Tangan */
        .footer-sign {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .sign-box {
            text-align: center;
            width: 220px;
        }

        /* Pengaturan Cetak / Simpan PDF */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body {
                background: #ffffff;
            }
            .page-container {
                max-width: 100%;
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }
            .action-bar {
                display: none !important;
            }
            th {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi Melayang -->
    <div class="action-bar">
        <button onclick="window.history.back()" class="btn btn-secondary">
            ← Kembali
        </button>
        <button onclick="window.print()" class="btn btn-primary">
            🖨️️ Cetak / Simpan Ke PDF
        </button>
    </div>

    <!-- Lembar Kertas Laporan -->
    <div class="page-container">
        
        <!-- Header Kop Surat Resmi ATR/BPN -->
        <div class="kop-surat">
            <div class="kop-logo">
                <img src="{{ asset('images/logo-bpn.png') }}" alt="Logo ATR/BPN">
            </div>
            <div class="kop-teks">
                <h2>KEMENTERIAN AGRARIA DAN TATA RUANG/<br>BADAN PERTANAHAN NASIONAL</h2>
                <h3>KANTOR PERTANAHAN KABUPATEN SUBANG</h3>
                <h4>PROVINSI JAWA BARAT</h4>
            </div>
        </div>
        <hr class="kop-garis">

        <!-- Judul Laporan -->
        <div class="doc-subheading">
            <h4>REKAPITULASI JADWAL PERSIDANGAN PERKARA PENANGANAN SENGKETA (PPS)</h4>
            @if(request('tanggal_mulai') && request('tanggal_selesai'))
                <p style="font-weight: bold; color: #000;">
                    Periode: {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->translatedFormat('d F Y') }}
                </p>
            @endif
        </div>

        <!-- Tabel Data Jadwal Sidang -->
        <table>
            <thead>
                <tr>
                    <th style="width: 35px;">No.</th>
                    <th style="width: 140px;">No. Perkara</th>
                    <th style="width: 150px;">Hari & Tanggal</th>
                    <th style="width: 80px;">Jam</th>
                    <th>Agenda Sidang</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $schedule)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ optional($schedule->perkara)->nomor_perkara ?? '-' }}</strong></td>
                    <td>{{ $schedule->hari ? $schedule->hari . ', ' : '' }}{{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }} WIB</td>
                    <td>{{ $schedule->agenda }}</td>
                    <td>{{ $schedule->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">
                        <em>Tidak ada data jadwal sidang pada rentang tanggal tersebut.</em>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Kolom Tanda Tangan -->
        <div class="footer-sign">
            <div class="sign-box">
                <p>Subang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p style="margin-bottom: 60px;">Petugas Pengelola Data,</p>
                <p><strong>( ________________________ )</strong></p>
            </div>
        </div>

    </div>

</body>
</html>