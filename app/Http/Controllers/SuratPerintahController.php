<?php

namespace App\Http\Controllers;

use App\Models\SuratPerintah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratPerintahController extends Controller
{
    /**
     * Menampilkan daftar Surat Perintah
     */
    public function index()
    {
        $suratPerintahs = SuratPerintah::latest()->get();

        // Mengarahkan ke view di folder resources/views/mediasi/surat_perintah/index.blade.php
        return view('mediasi.surat_perintah.index', compact('suratPerintahs'));
    }

    /**
     * Menyimpan data Surat Perintah baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'file'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat_perintah', 'public');
        }

        SuratPerintah::create([
            'nama_pemohon' => $request->nama_pemohon,
            'tanggal'      => $request->tanggal,
            'file_path'    => $filePath,
        ]);

        return redirect()->back()->with('success', 'Surat Perintah berhasil disimpan!');
    }

    /**
     * Menampilkan/melihat file dokumen secara inline di browser
     */
    public function viewFile($id)
    {
        $sp = SuratPerintah::findOrFail($id);

        // Cek apakah file ada di storage
        if (!$sp->file_path || !Storage::disk('public')->exists($sp->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($sp->file_path);
        $mimeType = Storage::disk('public')->mimeType($sp->file_path);

        // Menampilkan file langsung di browser (inline)
        return response()->file($filePath, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    /**
     * Menampilkan form edit Surat Perintah
     */
    public function edit($id)
    {
        $suratPerintah = SuratPerintah::findOrFail($id);

        return view('mediasi.surat_perintah.edit', compact('suratPerintah'));
    }

    /**
     * Memperbarui data Surat Perintah
     */
    public function update(Request $request, $id)
    {
        $suratPerintah = SuratPerintah::findOrFail($id);

        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'file'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5048',
        ]);

        $filePath = $suratPerintah->file_path;
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada file baru yang diunggah
            if ($suratPerintah->file_path && Storage::disk('public')->exists($suratPerintah->file_path)) {
                Storage::disk('public')->delete($suratPerintah->file_path);
            }

            $filePath = $request->file('file')->store('surat_perintah', 'public');
        }

        $suratPerintah->update([
            'nama_pemohon' => $request->nama_pemohon,
            'tanggal'      => $request->tanggal,
            'file_path'    => $filePath,
        ]);

        return redirect()->route('surat-perintah.index')->with('success', 'Surat Perintah berhasil diperbarui!');
    }

    /**
     * Menghapus data Surat Perintah
     */
    public function destroy($id)
    {
        $suratPerintah = SuratPerintah::findOrFail($id);

        // Hapus file fisik dari storage saat data dihapus
        if ($suratPerintah->file_path && Storage::disk('public')->exists($suratPerintah->file_path)) {
            Storage::disk('public')->delete($suratPerintah->file_path);
        }

        $suratPerintah->delete();

        return redirect()->back()->with('success', 'Surat Perintah berhasil dihapus!');
    }
}