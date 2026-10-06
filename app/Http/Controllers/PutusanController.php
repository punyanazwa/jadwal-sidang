<?php

namespace App\Http\Controllers;

use App\Models\Putusan;
use App\Models\CaseModel;
use Illuminate\Http\Request;

class PutusanController extends Controller
{
    public function index(Request $request)
    {
        $query = Putusan::with('perkara');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('perkara', function($q) use ($search) {
                $q->where('nomor_perkara', 'like', "%{$search}%")
                  ->orWhere('penggugat', 'like', "%{$search}%")
                  ->orWhere('tergugat', 'like', "%{$search}%");
            });
        }

        $putusans = $query->latest()->get();
        return view('putusan.index', compact('putusans'));
    }

    public function create()
    {
        // Ambil perkara yang belum memiliki putusan (opsional, agar 1 perkara 1 putusan)
        $perkaras = CaseModel::doesntHave('putusan')->get();
        return view('putusan.create', compact('perkaras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perkara_id'      => 'required|exists:perkara,id|unique:putusan,perkara_id',
            'tanggal_putusan' => 'required|date',
            'tanggal_bht'     => 'nullable|date',
            'amar_putusan'    => 'required|string',
        ]);

        Putusan::create($request->all());

        return redirect()->route('putusan.index')->with('success', 'Data putusan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $putusan = Putusan::findOrFail($id);
        $perkaras = CaseModel::all();
        return view('putusan.edit', compact('putusan', 'perkaras'));
    }

    public function update(Request $request, $id)
    {
        $putusan = Putusan::findOrFail($id);

        $request->validate([
            'perkara_id'      => 'required|exists:perkara,id',
            'tanggal_putusan' => 'required|date',
            'tanggal_bht'     => 'nullable|date',
            'amar_putusan'    => 'required|string',
        ]);

        $putusan->update($request->all());

        return redirect()->route('putusan.index')->with('success', 'Data putusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $putusan = Putusan::findOrFail($id);
        $putusan->delete();

        return back()->with('success', 'Data putusan berhasil dihapus.');
    }
}