<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerkaraController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseModel::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_perkara', 'like', "%{$search}%")
                  ->orWhere('penggugat', 'like', "%{$search}%")
                  ->orWhere('tergugat', 'like', "%{$search}%")
                  ->orWhere('nomor_sertifikat', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('desa_kelurahan', 'like', "%{$search}%");
            });
        }

        $perkara = $query->latest()->get();
        return view('perkara.index', compact('perkara'));
    }

    public function create()
    {
        return view('perkara.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_perkara'    => 'required|string|max:255|unique:perkara,nomor_perkara',
            'jenis_perkara'    => 'required|string|max:255',
            'penggugat'        => 'required|string',
            'tergugat'         => 'required|string',
            'turut_tergugat'   => 'nullable|string',
            'sertifikat'       => 'nullable|string|max:255',
            'nomor_sertifikat' => 'nullable|string', // <-- Dihapus max:255 agar bisa menampung banyak nomor
            'kecamatan'        => 'nullable|string|max:255',
            'desa_kelurahan'   => 'nullable|string|max:255',
            'pemegang_hak'     => 'nullable|string|max:255',
            'luas'             => 'nullable|string|max:255',
            'no_surat_kuasa'   => 'nullable|string|max:255',
            'tanggal'          => 'nullable|date',
            'penerima_kuasa'   => 'nullable|string|max:255',
            'keterangan'       => 'nullable|string',
        ]);

        $validated['dibuat_oleh'] = Auth::id();

        CaseModel::create($validated);

        return redirect()->route('perkara.index')->with('success', 'Data perkara berhasil ditambahkan.');
    }

    public function show($id)
    {
        $perkara = CaseModel::with('schedules')->findOrFail($id);
        return view('perkara.show', compact('perkara'));
    }

    public function edit($id)
    {
        $perkara = CaseModel::findOrFail($id);
        return view('perkara.edit', compact('perkara'));
    }

    public function update(Request $request, $id)
    {
        $perkara = CaseModel::findOrFail($id);

        $validated = $request->validate([
            'nomor_perkara'    => 'required|string|max:255|unique:perkara,nomor_perkara,'.$perkara->id,
            'jenis_perkara'    => 'required|string|max:255',
            'penggugat'        => 'required|string',
            'tergugat'         => 'required|string',
            'turut_tergugat'   => 'nullable|string',
            'sertifikat'       => 'nullable|string|max:255',
            'nomor_sertifikat' => 'nullable|string', // <-- Dihapus max:255 agar bisa menampung banyak nomor
            'kecamatan'        => 'nullable|string|max:255',
            'desa_kelurahan'   => 'nullable|string|max:255',
            'pemegang_hak'     => 'nullable|string|max:255',
            'luas'             => 'nullable|string|max:255',
            'no_surat_kuasa'   => 'nullable|string|max:255',
            'tanggal'          => 'nullable|date',
            'penerima_kuasa'   => 'nullable|string|max:255',
            'keterangan'       => 'nullable|string',
        ]);

        $perkara->update($validated);

        return redirect()->route('perkara.index')->with('success', 'Data perkara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $perkara = CaseModel::findOrFail($id);
        $perkara->delete();

        return back()->with('success', 'Data perkara berhasil dihapus.');
    }
}