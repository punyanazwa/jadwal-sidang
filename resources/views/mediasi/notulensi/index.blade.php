@extends('layouts.main')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px;">📝 Data Notulensi Mediasi</h2>

    <!-- Form Tambah Data -->
    <form action="{{ route('notulensi.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 30px; background: #f8fafc; padding: 20px; border-radius: var(--radius); border: 1px solid var(--border);">
        @csrf
        <h4 style="margin-bottom: 15px;">Tambah Notulensi Baru</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Pilih Undangan Mediasi</label>
                <select name="undangan_mediasi_id" class="form-control" required>
                    <option value="">-- Pilih Undangan --</option>
                    @foreach($undanganMediasis as $um)
                        <option value="{{ $um->id }}">{{ $um->pihak_diundang }} ({{ \Carbon\Carbon::parse($um->tanggal)->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>File Notulensi</label>
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
                    <th>Pihak Diundang (Undangan)</th>
                    <th>Tanggal Undangan</th>
                    <th>Dokumen Notulensi</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notulensis as $index => $n)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $n->undanganMediasi->pihak_diundang ?? '-' }}</strong></td>
                        <td>{{ $n->undanganMediasi ? \Carbon\Carbon::parse($n->undanganMediasi->tanggal)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($n->file_path)
                                <a href="{{ asset('storage/' . $n->file_path) }}" target="_blank" class="btn btn-sm">📄 Lihat File</a>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="display: flex; gap: 6px;">
                            <a href="{{ route('notulensi.edit', $n->id) }}" class="btn btn-sm">✏️ Edit</a>
                            <form action="{{ route('notulensi.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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