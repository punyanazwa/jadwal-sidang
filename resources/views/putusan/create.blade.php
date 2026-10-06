@extends('layouts.main', ['title' => 'Input Putusan Perkara'])

@section('content')
<div class="card" style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; max-width: 700px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Form Input Putusan Perkara</h3>

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('putusan.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 6px;">Pilih Nomor Perkara</label>
            <select name="perkara_id" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background: #fff;">
                <option value="">-- Pilih Perkara --</option>
                @foreach($perkaras as $p)
                    <option value="{{ $p->id }}" {{ old('perkara_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nomor_perkara }} (Penggugat: {{ $p->penggugat }} vs Tergugat: {{ $p->tergugat }})
                    </option>
                @endforeach
            </select>
            <small style="color: #64748b; font-size: 12px;">*Hanya menampilkan perkara yang belum memiliki putusan.</small>
        </div>

        <div style="display: flex; gap: 16px; margin-bottom: 16px;">
            <div style="flex: 1;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 6px;">Tanggal Putusan</label>
                <input type="date" name="tanggal_putusan" value="{{ old('tanggal_putusan') }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 6px;">Tanggal BHT (Berkekuatan Hukum Tetap)</label>
                <input type="date" name="tanggal_bht" value="{{ old('tanggal_bht') }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 6px;">Amar Putusan</label>
            <textarea name="amar_putusan" rows="6" placeholder="M E N G A D I L I : ..." required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; font-family: inherit;">{{ old('amar_putusan') }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #0d9488; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500;">Simpan Putusan</button>
            <a href="{{ route('putusan.index') }}" style="background: #64748b; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-block;">Batal</a>
        </div>
    </form>
</div>
@endsection