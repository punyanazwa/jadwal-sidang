<?php

namespace App\Http\Controllers;

use App\Models\UndanganMediasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UndanganMediasiController extends Controller
{
    public function index()
    {
        $undanganMediasis = UndanganMediasi::latest()->get();
        return view('mediasi.undangan_mediasi.index', compact('undanganMediasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pihak_diundang' => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'file'           => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('undangan_mediasi', 'public');
        }

        UndanganMediasi::create([
            'pihak_diundang' => $request->pihak_diundang,
            'tanggal'        => $request->tanggal,
            'file_path'      => $filePath,
        ]);

        return redirect()->back()->with('success', 'Data Undangan Mediasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $undanganMediasi = UndanganMediasi::findOrFail($id);
        return view('mediasi.undangan_mediasi.edit', compact('undanganMediasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pihak_diundang' => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'file'           => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048',
        ]);

        $um = UndanganMediasi::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($um->file_path && Storage::disk('public')->exists($um->file_path)) {
                Storage::disk('public')->delete($um->file_path);
            }
            $um->file_path = $request->file('file')->store('undangan_mediasi', 'public');
        }

        $um->update([
            'pihak_diundang' => $request->pihak_diundang,
            'tanggal'        => $request->tanggal,
            'file_path'      => $um->file_path,
        ]);

        return redirect()->route('undangan-mediasi.index')->with('success', 'Data Undangan Mediasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $um = UndanganMediasi::findOrFail($id);
        if ($um->file_path && Storage::disk('public')->exists($um->file_path)) {
            Storage::disk('public')->delete($um->file_path);
        }
        $um->delete();

        return redirect()->back()->with('success', 'Data Undangan Mediasi berhasil dihapus!');
    }
}