@extends('layouts.main')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px;">📄 Data Surat Perintah</h2>

    <!-- Form Tambah Data -->
    <form action="{{ route('surat-perintah.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 30px; background: #f8fafc; padding: 20px; border-radius: var(--radius); border: 1px solid var(--border);">
        @csrf
        <h4 style="margin-bottom: 15px;">Tambah Surat Perintah Baru</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <div class="form-group">
                <label>Nama Pemohon</label>
                <input type="text" name="nama_pemohon" class="form-control" required placeholder="Masukkan nama pemohon">
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
                    <th>Nama Pemohon</th>
                    <th>Tanggal</th>
                    <th>Dokumen</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratPerintahs as $index => $sp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $sp->nama_pemohon }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($sp->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @if($sp->file_path)
                                <!-- Single button linked to controller endpoint -->
                                <a href="{{ route('surat-perintah.view', $sp->id) }}" target="_blank" class="btn btn-sm">
                                    📄 Lihat File
                                </a>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('surat-perintah.edit', $sp->id) }}" class="btn btn-sm">✏️ Edit</a>
                                <form action="{{ route('surat-perintah.destroy', $sp->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️️ Hapus</button>
                                </form>
                            </div>
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