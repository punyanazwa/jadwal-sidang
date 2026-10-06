@extends('layouts.main')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px;">✉️ Data Undangan Mediasi</h2>

    <!-- Form Tambah Data -->
    <form action="{{ route('undangan-mediasi.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 30px; background: #f8fafc; padding: 20px; border-radius: var(--radius); border: 1px solid var(--border);">
        @csrf
        <h4 style="margin-bottom: 15px;">Tambah Undangan Mediasi Baru</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Pihak yang Diundang</label>
                <input type="text" name="pihak_diundang" class="form-control" required placeholder="Masukkan pihak yang diundang">
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="form-group">
                <label>File Dokumen</label>
                <input type="file" name="file" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn" style="margin-top: 15px;">➕ Simpan Data</button>
    </form>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Pihak Diundang</th>
                    <th>Tanggal</th>
                    <th>Dokumen</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($undanganMediasis as $index => $um)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $um->pihak_diundang }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($um->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @if($um->file_path)
                                <a href="{{ asset('storage/' . $um->file_path) }}" target="_blank" class="btn btn-sm">📄 Lihat File</a>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="display: flex; gap: 6px;">
                            <a href="{{ route('undangan-mediasi.edit', $um->id) }}" class="btn btn-sm">✏️ Edit</a>
                            <form action="{{ route('undangan-mediasi.destroy', $um->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted);">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection