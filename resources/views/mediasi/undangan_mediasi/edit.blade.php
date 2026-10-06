@extends('layouts.main')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px;">✏️ Edit Undangan Mediasi</h2>

    <form action="{{ route('undangan-mediasi.update', $undanganMediasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Pihak yang Diundang</label>
            <input type="text" name="pihak_diundang" class="form-control" value="{{ $undanganMediasi->pihak_diundang }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $undanganMediasi->tanggal }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>File Dokumen (Kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="file" class="form-control">
            @if($undanganMediasi->file_path)
                <p style="margin-top: 5px;"><small>File saat ini: <a href="{{ asset('storage/' . $undanganMediasi->file_path) }}" target="_blank">Lihat File</a></small></p>
            @endif
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">💾 Perbarui Data</button>
            <a href="{{ route('undangan-mediasi.index') }}" class="btn" style="background: #6c757d; color: white;">Kembali</a>
        </div>
    </form>
</div>
@endsection