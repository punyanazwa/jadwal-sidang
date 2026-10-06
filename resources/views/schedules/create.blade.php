@extends('layouts.main', ['title' => 'Tambah Jadwal Sidang'])

@section('content')
<div class="card" style="max-width: 700px; margin: 0 auto;">
    <h3 style="margin-bottom: 20px;">Tambah Jadwal Sidang</h3>

    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <!-- Pilihan Nomor Perkara -->
            <div class="form-group">
                <label>Nomor Perkara *</label>
                <select name="perkara_id" class="form-control select2" required style="width: 100%; padding: 8px;">
                    <option value="">-- Pilih atau Ketik Nomor Perkara / Penggugat --</option>
                    @foreach($perkaras as $p)
                        <option value="{{ $p->id }}" {{ old('perkara_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nomor_perkara }} — (Penggugat: {{ Str::limit($p->penggugat, 30) }})
                        </option>
                    @endforeach
                </select>
                @error('perkara_id')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Tanggal Sidang *</label>
                    <input type="date" id="tanggal_sidang" name="tanggal" class="form-control" required value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Hari *</label>
                    <input type="text" id="hari_sidang" name="hari" class="form-control" placeholder="Otomatis terisi..." readonly required value="{{ old('hari') }}">
                    @error('hari')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Jam Sidang *</label>
                    <input type="time" name="jam" class="form-control" required value="{{ old('jam') }}">
                    @error('jam')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Agenda Sidang *</label>
                    <input type="text" name="agenda" class="form-control" placeholder="Contoh: Pembuktian / Mediasi" required value="{{ old('agenda') }}">
                    @error('agenda')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="margin-top: 25px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Simpan Jadwal</button>
            <a href="{{ route('schedules.index') }}" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>

<!-- Script Select2 & Auto Day -->
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Pilih atau Ketik Nomor Perkara --",
            allowClear: true
        });

        // fungsi otomatis tentukan hari
        function updateHari() {
            const val = $('#tanggal_sidang').val();
            if (val) {
                const parts = val.split('-');
                const dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
                const namaHari = dateObj.toLocaleDateString('id-ID', { weekday: 'long' });
                $('#hari_sidang').val(namaHari);
            } else {
                $('#hari_sidang').val('');
            }
        }

        $('#tanggal_sidang').on('change', updateHari);

        if ($('#tanggal_sidang').val()) {
            updateHari();
        }
    });
</script>
@endpush
@endsection