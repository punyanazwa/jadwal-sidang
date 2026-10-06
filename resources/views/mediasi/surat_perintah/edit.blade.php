@extends('layouts.main')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px;">✏️ Edit Surat Perintah</h2>

    <form action="{{ route('surat-perintah.update', $suratPerintah->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label>Nama Pemohon</label>
            <input type="text" name="nama_pemohon" class="form-control" value="{{ $suratPerintah->nama_pemohon }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $suratPerintah->tanggal }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>File Dokumen (Kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="file" class="form-control">
            @if($suratPerintah->file_path)
                <p style="margin-top: 5px;"><small>File saat ini: <a href="{{ asset('storage/' . $suratPerintah->file_path) }}" target="_blank">Lihat File</a></small></p>
            @endif
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">💾 Perbarui Data</button>
            <a href="{{ route('surat-perintah.index') }}" class="btn" style="background: #6c757d; color: white;">Kembali</a>
        </div>
    </form>
</div>
@endsection