@extends('layouts.main', ['title' => 'Dashboard Utama'])

@section('content')
<style>
    .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid var(--border); border-left: 5px solid var(--primary); }
    .stat-card h4 { color: var(--text-muted); font-size: 13px; text-transform: uppercase; margin-bottom: 8px; }
    .stat-card .number { font-size: 28px; font-weight: bold; color: var(--text-dark); }
</style>

<div class="grid-stats">
    <div class="stat-card">
        <h4>Sidang Hari Ini</h4>
        <div class="number">{{ $countToday }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #eab308;">
        <h4>Sidang Minggu Ini</h4>
        <div class="number">{{ $countWeek }}</div>
    </div>
    <div class="stat-card" style="border-left-color: #22c55e;">
        <h4>Sidang Mendatang</h4>
        <div class="number">{{ $countUpcoming }}</div>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 15px;">5 Jadwal Sidang Terbaru</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No Perkara</th>
                    <th>Penggugat</th>
                    <th>Tergugat</th>
                    <th>Tanggal & Waktu</th>
                    <th>Hari</th>
                    <th>Agenda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest as $item)
                <tr>
                    <td><strong>{{ $item->perkara->nomor_perkara ?? '-' }}</strong></td>
                    <td>{{ $item->perkara->penggugat ?? '-' }}</td>
                    <td>{{ $item->perkara->tergugat ?? '-' }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->tanggal)) }} ({{ substr($item->jam, 0, 5) }})</td>
                    <td>{{ $item->hari }}</td>
                    <td>{{ $item->agenda }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data jadwal sidang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection