@extends('layouts.main', ['title' => 'Edit Perkara'])

@section('content')
<div class="card">
    <h3 style="margin-bottom: 20px;">Edit Data Perkara</h3>

    <form action="{{ route('perkara.update', $perkara->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label>Nomor Perkara *</label>
                <input type="text" name="nomor_perkara" class="form-control" required value="{{ old('nomor_perkara', $perkara->nomor_perkara) }}">
                @error('nomor_perkara')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Jenis Perkara *</label>
                <input type="text" name="jenis_perkara" class="form-control" required value="{{ old('jenis_perkara', $perkara->jenis_perkara) }}">
                @error('jenis_perkara')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Penggugat * (Bisa dientri lebih dari 1 nama dengan Enter)</label>
                <textarea name="penggugat" class="form-control" rows="3" required>{{ old('penggugat', $perkara->penggugat) }}</textarea>
                @error('penggugat')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Tergugat * (Bisa dientri lebih dari 1 nama dengan Enter)</label>
                <textarea name="tergugat" class="form-control" rows="3" required>{{ old('tergugat', $perkara->tergugat) }}</textarea>
                @error('tergugat')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Turut Tergugat (Opsional)</label>
                <textarea name="turut_tergugat" class="form-control" rows="2">{{ old('turut_tergugat', $perkara->turut_tergugat) }}</textarea>
                @error('turut_tergugat')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Jenis Sertifikat (Enter untuk lebih dari 1)</label>
                <textarea name="sertifikat" class="form-control" rows="3" placeholder="misal:&#10;HGB&#10;M">{{ old('sertifikat', $perkara->sertifikat) }}</textarea>
                @error('sertifikat')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Nomor Sertifikat (Enter untuk lebih dari 1)</label>
                <textarea name="nomor_sertifikat" class="form-control" rows="3" placeholder="misal:&#10;134&#10;88">{{ old('nomor_sertifikat', $perkara->nomor_sertifikat) }}</textarea>
                @error('nomor_sertifikat')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Luas (m²) (Enter untuk lebih dari 1)</label>
                <textarea name="luas" class="form-control" rows="3" placeholder="misal:&#10;56&#10;100">{{ old('luas', $perkara->luas) }}</textarea>
                @error('luas')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $perkara->kecamatan) }}">
                @error('kecamatan')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Desa / Kelurahan</label>
                <input type="text" name="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan', $perkara->desa_kelurahan) }}">
                @error('desa_kelurahan')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Pemegang Hak</label>
                <input type="text" name="pemegang_hak" class="form-control" value="{{ old('pemegang_hak', $perkara->pemegang_hak) }}">
                @error('pemegang_hak')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>No. Surat Kuasa</label>
                <input type="text" name="no_surat_kuasa" class="form-control" value="{{ old('no_surat_kuasa', $perkara->no_surat_kuasa) }}">
                @error('no_surat_kuasa')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label>Tanggal Surat Kuasa</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $perkara->tanggal) }}">
                @error('tanggal')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Penerima Kuasa</label>
                <input type="text" name="penerima_kuasa" class="form-control" value="{{ old('penerima_kuasa', $perkara->penerima_kuasa) }}">
                @error('penerima_kuasa')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $perkara->keterangan) }}</textarea>
                @error('keterangan')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn">Perbarui Perkara</button>
            <a href="{{ route('perkara.index') }}" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>
@endsection