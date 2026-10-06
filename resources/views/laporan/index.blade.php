@extends('layouts.main', ['title' => 'Laporan Sidang Selesai'])

@section('content')
<div class="card" style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px;">
    
    <!-- Header & Tombol Cetak -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;" class="no-print">
        <div>
            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1e293b;">
                Laporan Rekapitulasi Sidang Selesai 
                @if($pengadilan) <span style="color: #2563eb;">- Khusus {{ $pengadilan }}</span> @endif
            </h3>
            <p style="color: #64748b; font-size: 13px; margin: 4px 0 0 0;">Klik bubble pengadilan untuk berpindah dan menampilkan seluruh data pengadilan tersebut.</p>
        </div>
        <button onclick="window.print()" class="btn" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">
            🖨️ Cetak Laporan
        </button>
    </div>

    <!-- 5 BUBBLE PENGADILAN -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 24px;" class="no-print">
        
        <!-- PN -->
        <a href="{{ route('laporan.index', 'PN') }}" style="text-decoration: none;">
            <div style="padding: 14px; border-radius: 8px; border-left: 4px solid #2563eb; background: {{ $pengadilan == 'PN' ? '#eff6ff' : '#f8fafc' }}; border: {{ $pengadilan == 'PN' ? '2px solid #2563eb' : '1px solid #e2e8f0' }}; cursor: pointer;">
                <div style="font-size: 11px; font-weight: 700; color: #2563eb; text-transform: uppercase;">Pengadilan Negeri (PN)</div>
                <div style="font-size: 22px; font-weight: 700; color: #1e293b; margin-top: 4px;">{{ $countPN }}</div>
            </div>
        </a>

        <!-- PA -->
        <a href="{{ route('laporan.index', 'PA') }}" style="text-decoration: none;">
            <div style="padding: 14px; border-radius: 8px; border-left: 4px solid #eab308; background: {{ $pengadilan == 'PA' ? '#fefce8' : '#f8fafc' }}; border: {{ $pengadilan == 'PA' ? '2px solid #eab308' : '1px solid #e2e8f0' }}; cursor: pointer;">
                <div style="font-size: 11px; font-weight: 700; color: #ca8a04; text-transform: uppercase;">Pengadilan Agama (PA)</div>
                <div style="font-size: 22px; font-weight: 700; color: #1e293b; margin-top: 4px;">{{ $countPA }}</div>
            </div>
        </a>

        <!-- PTUN -->
        <a href="{{ route('laporan.index', 'PTUN') }}" style="text-decoration: none;">
            <div style="padding: 14px; border-radius: 8px; border-left: 4px solid #16a34a; background: {{ $pengadilan == 'PTUN' ? '#f0fdf4' : '#f8fafc' }}; border: {{ $pengadilan == 'PTUN' ? '2px solid #16a34a' : '1px solid #e2e8f0' }}; cursor: pointer;">
                <div style="font-size: 11px; font-weight: 700; color: #16a34a; text-transform: uppercase;">PTUN Bandung</div>
                <div style="font-size: 22px; font-weight: 700; color: #1e293b; margin-top: 4px;">{{ $countPTUN }}</div>
            </div>
        </a>

        <!-- PT -->
        <a href="{{ route('laporan.index', 'PT') }}" style="text-decoration: none;">
            <div style="padding: 14px; border-radius: 8px; border-left: 4px solid #0891b2; background: {{ $pengadilan == 'PT' ? '#ecfeff' : '#f8fafc' }}; border: {{ $pengadilan == 'PT' ? '2px solid #0891b2' : '1px solid #e2e8f0' }}; cursor: pointer;">
                <div style="font-size: 11px; font-weight: 700; color: #0891b2; text-transform: uppercase;">Pengadilan Tinggi (PT)</div>
                <div style="font-size: 22px; font-weight: 700; color: #1e293b; margin-top: 4px;">{{ $countPT }}</div>
            </div>
        </a>

        <!-- MA -->
        <a href="{{ route('laporan.index', 'MA') }}" style="text-decoration: none;">
            <div style="padding: 14px; border-radius: 8px; border-left: 4px solid #dc2626; background: {{ $pengadilan == 'MA' ? '#fef2f2' : '#f8fafc' }}; border: {{ $pengadilan == 'MA' ? '2px solid #dc2626' : '1px solid #e2e8f0' }}; cursor: pointer;">
                <div style="font-size: 11px; font-weight: 700; color: #dc2626; text-transform: uppercase;">Mahkamah Agung (MA)</div>
                <div style="font-size: 22px; font-weight: 700; color: #1e293b; margin-top: 4px;">{{ $countMA }}</div>
            </div>
        </a>

    </div>

    <!-- FORM FILTER RENTANG BULAN, TAHUN & PENCARIAN -->
    <form action="{{ route('laporan.index', $pengadilan) }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; margin-bottom: 20px;" class="no-print">

        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center; flex: 1;">
            
            <!-- Select Dari Bulan -->
            <select name="bulan_mulai" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; outline: none; background: white;">
                <option value="">-- Dari Bulan --</option>
                @foreach([
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                    '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ] as $key => $namaBulan)
                    <option value="{{ $key }}" {{ $bulan_mulai == $key ? 'selected' : '' }}>{{ $namaBulan }}</option>
                @endforeach
            </select>

            <span style="font-size: 13px; color: #64748b; font-weight: 500;">s/d</span>

            <!-- Select Sampai Bulan -->
            <select name="bulan_akhir" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; outline: none; background: white;">
                <option value="">-- Sampai Bulan --</option>
                @foreach([
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                    '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ] as $key => $namaBulan)
                    <option value="{{ $key }}" {{ $bulan_akhir == $key ? 'selected' : '' }}>{{ $namaBulan }}</option>
                @endforeach
            </select>

            <!-- Select Tahun -->
            <select name="tahun" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; outline: none; background: white;">
                <option value="">-- Semua Tahun --</option>
                @for($i = date('Y'); $i >= 2020; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
                @endfor
            </select>

            <!-- Input Search -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Perkara/Agenda..." style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; outline: none; min-width: 180px;">

            <button type="submit" style="background: #2563eb; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500;">Filter</button>
            
            <a href="{{ route('laporan.index', $pengadilan) }}" style="background: #64748b; color: white; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 13px;">Reset Filter</a>
        </div>

        <!-- JUMLAH KESELURUHAN HASIL FILTER -->
        <div>
            <span style="font-size: 13px; font-weight: 600; background: #f1f5f9; color: #1e293b; padding: 8px 16px; border-radius: 20px; border: 1px solid #e2e8f0;">
                Jumlah Keseluruhan : <strong style="color: #2563eb;">{{ $countAll }}</strong>
            </span>
        </div>
    </form>

    <!-- BAR INFO PENGADILAN KETIKA SEDANG MEMBUKA BUBBLE -->
    @if($pengadilan)
        <div style="margin-bottom: 15px; padding: 10px 14px; background: #eff6ff; border-radius: 6px; border-left: 4px solid #2563eb; font-size: 13px; color: #1e3a8a; display: flex; justify-content: space-between; align-items: center;" class="no-print">
            <span>Menampilkan seluruh data laporan khusus: <strong>{{ $pengadilan }}</strong></span>
            <a href="{{ route('laporan.index') }}" style="color: #dc2626; text-decoration: none; font-weight: 600;">Kembali ke Semua Laporan ✕</a>
        </div>
    @endif

    <!-- TABEL DATA LAPORAN -->
    <div>
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background: #f8fafc; color: #475569;">
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; width: 5%;">No</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; width: 22%;">No. Perkara</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; width: 18%;">Hari & Tanggal</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; width: 10%;">Jam</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; width: 25%;">Agenda</th>
                        <th style="padding: 10px; border-bottom: 2px solid #e2e8f0; width: 20%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $index => $s)
                    <tr style="border-bottom: 1px solid #f1f5f9; color: #334155;">
                        <td style="padding: 10px; vertical-align: top;">{{ $schedules->firstItem() + $index }}</td>
                        
                        <td style="padding: 10px; vertical-align: top;">
                            @if(optional($s->perkara)->id)
                                <a href="{{ route('perkara.show', ['perkara' => optional($s->perkara)->id, 'from' => 'report']) }}" style="font-weight: 600; color: #2563eb; text-decoration: none;">
                                    {{ optional($s->perkara)->nomor_perkara ?? '-' }}
                                </a>
                            @else
                                <span style="color: #64748b;">-</span>
                            @endif
                        </td>

                        <td style="padding: 10px; vertical-align: top;">
                            <span style="text-transform: capitalize;">{{ $s->hari }}</span>, {{ \Carbon\Carbon::parse($s->tanggal)->format('d-m-Y') }}
                        </td>
                        <td style="padding: 10px; vertical-align: top;">{{ \Carbon\Carbon::parse($s->jam)->format('H:i') }} WIB</td>
                        <td style="padding: 10px; vertical-align: top;">{{ $s->agenda }}</td>
                        <td style="padding: 10px; vertical-align: top; color: #64748b;">
                            {{ $s->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 40px 10px;">
                            <div style="font-size: 15px; font-weight: 500; color: #64748b; margin-bottom: 4px;">Tidak ada data ditemukan</div>
                            <div style="font-size: 13px;">Belum ada data jadwal sidang yang sesuai dengan rentang filter ini.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;" class="no-print">
            {{ $schedules->links() }}
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .topbar, .no-print, header {
        display: none !important;
    }
    .content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    body {
        background: white !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection