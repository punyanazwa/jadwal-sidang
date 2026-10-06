<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request, $pengadilan = null)
    {
        // Parameter Filter
        $bulan_mulai = $request->get('bulan_mulai');
        $bulan_akhir = $request->get('bulan_akhir');
        $tahun       = $request->get('tahun'); // Tidak ada default year agar data bubble tidak terpotong
        $search      = $request->get('search');

        // 1. STATISTIK ANGKAMASING-MASING BUBBLE (TOTAL SELURUHNYA)
        $statisQuery = Schedule::whereHas('perkara')
            ->whereDate('tanggal', '<', today());

        $countPN   = (clone $statisQuery)->whereHas('perkara', fn($q) => $q->where('nomor_perkara', 'like', '%PN%'))->count();
        $countPA   = (clone $statisQuery)->whereHas('perkara', fn($q) => $q->where('nomor_perkara', 'like', '%PA%'))->count();
        $countPTUN = (clone $statisQuery)->whereHas('perkara', fn($q) => $q->where('nomor_perkara', 'like', '%PTUN%'))->count();
        $countPT   = (clone $statisQuery)->whereHas('perkara', fn($q) => $q->where('nomor_perkara', 'like', '%PT%')->where('nomor_perkara', 'not like', '%PTUN%'))->count();
        $countMA   = (clone $statisQuery)->whereHas('perkara', fn($q) => $q->where('nomor_perkara', 'like', '%MA%'))->count();

        // 2. QUERY UTAMA SESUAI FILTER/PENGADILAN
        $query = Schedule::whereHas('perkara')
            ->whereDate('tanggal', '<', today());

        // Filter Spesifik Pengadilan jika Bubble Diklik
        if ($pengadilan) {
            $pengadilan = strtoupper($pengadilan);
            if ($pengadilan === 'PT') {
                $query->whereHas('perkara', function($q) {
                    $q->where('nomor_perkara', 'like', '%PT%')
                      ->where('nomor_perkara', 'not like', '%PTUN%');
                });
            } else {
                $query->whereHas('perkara', function($q) use ($pengadilan) {
                    $q->where('nomor_perkara', 'like', "%{$pengadilan}%");
                });
            }
        }

        // Filter Rentang Bulan (Bulan Mulai s/d Bulan Akhir)
        if ($bulan_mulai && $bulan_akhir) {
            $query->whereRaw('MONTH(tanggal) BETWEEN ? AND ?', [(int)$bulan_mulai, (int)$bulan_akhir]);
        } elseif ($bulan_mulai) {
            $query->whereMonth('tanggal', '>=', (int)$bulan_mulai);
        } elseif ($bulan_akhir) {
            $query->whereMonth('tanggal', '<=', (int)$bulan_akhir);
        }

        // Filter Tahun (Hanya jika dipiih pengguna)
        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        // Filter Kata Kunci Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($search) {
                $q->where('agenda', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('perkara', function($subQuery) use ($search) {
                      $subQuery->where('nomor_perkara', 'like', "%{$search}%")
                               ->orWhere('penggugat', 'like', "%{$search}%")
                               ->orWhere('tergugat', 'like', "%{$search}%");
                  });
            });
        }

        // Hitung total hasil filter aktif
        $countAll = $query->count();

        // Data Paginated
        $schedules = $query->with('perkara')
            ->orderBy('tanggal', 'desc')
            ->paginate(15)
            ->appends($request->query());

        return view('laporan.index', compact(
            'schedules',
            'countPN',
            'countPA',
            'countPTUN',
            'countPT',
            'countMA',
            'countAll',
            'pengadilan',
            'bulan_mulai',
            'bulan_akhir',
            'tahun'
        ));
    }
}