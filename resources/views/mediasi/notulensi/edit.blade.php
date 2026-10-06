@extends('layouts.main')

@section('content')
<div class="card">
    <h2 style="margin-bottom: 20px;">✏️ Edit Notulensi Mediasi</h2>

    <form action="{{ route('notulensi.update', $notulensi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Pilih Undangan Mediasi</label>
            <select name="undangan_mediasi_id" class="form-control" required>
                <option value="">-- Pilih Undangan --</option>
                @foreach($undanganMediasis as $um)
                    <option value="{{ $um->id }}" {{ $notulensi->undangan_mediasi_id == $um->id ? 'selected' : '' }}>
                        {{ $um->pihak_diundang }} ({{ \Carbon\Carbon::parse($um->tanggal)->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>File Notulensi (Kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="file" class="form-control">
            @if($notulensi->file_path)
                <p style="margin-top: 5px;"><small>File saat ini: <a href="{{ asset('storage/' . $notulensi->file_path) }}" target="_blank">Lihat File</a></small></p>
            @endif
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">💾 Perbarui Data</button>
            <a href="{{ route('notulensi.index') }}" class="btn" style="background: #6c757d; color: white;">Kembali</a>
        </div>
    </form>
</div>
@endsection