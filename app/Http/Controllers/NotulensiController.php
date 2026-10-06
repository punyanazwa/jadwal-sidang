<?php

namespace App\Http\Controllers;

use App\Models\Notulensi;
use App\Models\UndanganMediasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotulensiController extends Controller
{
    public function index()
    {
        $notulensis = Notulensi::with('undanganMediasi')->latest()->get();
        $undanganMediasis = UndanganMediasi::all();
        return view('mediasi.notulensi.index', compact('notulensis', 'undanganMediasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'undangan_mediasi_id' => 'required|exists:undangan_mediasis,id',
            'file'                => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('notulensi', 'public');
        }

        Notulensi::create([
            'undangan_mediasi_id' => $request->undangan_mediasi_id,
            'file_path'           => $filePath,
        ]);

        return redirect()->back()->with('success', 'Data Notulensi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $notulensi = Notulensi::findOrFail($id);
        $undanganMediasis = UndanganMediasi::all();
        return view('mediasi.notulensi.edit', compact('notulensi', 'undanganMediasis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'undangan_mediasi_id' => 'required|exists:undangan_mediasis,id',
            'file'                => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048',
        ]);

        $n = Notulensi::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($n->file_path && Storage::disk('public')->exists($n->file_path)) {
                Storage::disk('public')->delete($n->file_path);
            }
            $n->file_path = $request->file('file')->store('notulensi', 'public');
        }

        $n->update([
            'undangan_mediasi_id' => $request->undangan_mediasi_id,
            'file_path'           => $n->file_path,
        ]);

        return redirect()->route('notulensi.index')->with('success', 'Data Notulensi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $n = Notulensi::findOrFail($id);
        if ($n->file_path && Storage::disk('public')->exists($n->file_path)) {
            Storage::disk('public')->delete($n->file_path);
        }
        $n->delete();

        return redirect()->back()->with('success', 'Data Notulensi berhasil dihapus!');
    }
}