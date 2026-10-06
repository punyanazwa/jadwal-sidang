<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\CaseModel;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function dashboard()
    {
        $totalPerkara = CaseModel::count();
        $totalSchedules = Schedule::count();
        
        $countToday = Schedule::whereDate('tanggal', today())->count();
        $countWeek = Schedule::whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $countUpcoming = Schedule::whereDate('tanggal', '>', today())->count();
        
        // Hanya mengambil 5 jadwal terbaru yang hari ini atau akan datang
        $latest = Schedule::with('perkara')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalPerkara', 
            'totalSchedules', 
            'countToday', 
            'countWeek', 
            'countUpcoming', 
            'latest'
        ));
    }

    public function index(Request $request)
    {
        $query = Schedule::with('perkara');

        // Jika user melakukan filter berdasarkan rentang tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            // Jika difilter, tampilkan semua data hasil pencarian tanggal agar pas untuk direkap/diprint
            $schedules = $query->orderBy('tanggal', 'asc')->get();
        } else {
            // Hanya menampilkan jadwal hari ini dan yang akan datang (tanggal yang sudah lewat tersembunyi)
            $schedules = $query->whereDate('tanggal', '>=', today())
                ->orderBy('tanggal', 'asc')
                ->paginate(10)
                ->withQueryString();
        }

        return view('schedules.index', compact('schedules'));
    }

    // Fungsi untuk menangani cetak/print jadwal sidang sesuai filter tanggal
    public function print(Request $request)
    {
        $query = Schedule::with('perkara');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } else {
            // Jika diprint tanpa filter tanggal, cetak jadwal dari hari ini ke depan
            $query->whereDate('tanggal', '>=', today());
        }

        $schedules = $query->orderBy('tanggal', 'asc')->get();

        return view('schedules.print', compact('schedules'));
    }

    public function create()
    {
        $perkaras = CaseModel::all();
        return view('schedules.create', compact('perkaras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'perkara_id' => 'required|exists:perkara,id',
            'hari'       => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
            'agenda'     => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Jadwal sidang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $schedule = Schedule::with('perkara')->findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $perkaras = CaseModel::all();
        return view('schedules.edit', compact('schedule', 'perkaras'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'perkara_id' => 'required|exists:perkara,id',
            'hari'       => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
            'agenda'     => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Jadwal sidang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Jadwal sidang berhasil dihapus.');
    }
}