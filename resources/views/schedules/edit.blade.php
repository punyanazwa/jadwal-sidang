@extends('layouts.main', ['title' => 'Edit Jadwal Sidang'])

@section('content')
<div class="card" style="max-width: 700px; margin: 0 auto;">
    <h3 style="margin-bottom: 20px;">Edit Jadwal Sidang</h3>

    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <!-- Pilihan Nomor Perkara -->
            <div class="form-group">
                <label>Nomor Perkara *</label>
                <select name="perkara_id" class="form-control select2" required style="width: 100%; padding: 8px;">
                    <option value="">-- Pilih atau Ketik Nomor Perkara / Penggugat --</option>
                    @foreach($perkaras as $p)
                        <option value="{{ $p->id }}" {{ old('perkara_id', $schedule->perkara_id) == $p->id ? 'selected' : '' }}>
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
                    <input type="date" id="input_tanggal" name="tanggal" class="form-control" required value="{{ old('tanggal', $schedule->tanggal) }}">
                    @error('tanggal')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Hari *</label>
                    <input type="text" id="input_hari" name="hari" class="form-control" readonly required value="{{ old('hari', $schedule->hari) }}">
                    @error('hari')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Jam Sidang *</label>
                    <input type="time" name="jam" class="form-control" required value="{{ old('jam', $schedule->jam) }}">
                    @error('jam')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Agenda Sidang *</label>
                    <input type="text" name="agenda" class="form-control" placeholder="Contoh: Pembuktian / Mediasi" required value="{{ old('agenda', $schedule->agenda) }}">
                    @error('agenda')
                        <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan...">{{ old('keterangan', $schedule->keterangan) }}</textarea>
                @error('keterangan')
                    <small style="color: red; display: block; margin-top: 4px;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="margin-top: 25px; display: flex; gap: 10px;">
            <button type="submit" class="btn">Perbarui Jadwal</button>
            <a href="{{ route('schedules.index') }}" class="btn" style="background: #64748b;">Batal</a>
        </div>
    </form>
</div>

<!-- Script Vanilla JS + jQuery (Bisa jalan tanpa kebergantungan library eksternal) -->
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi Select2
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select2').select2({
                placeholder: "-- Pilih atau Ketik Nomor Perkara --",
                allowClear: true
            });
        }

        const elTanggal = document.getElementById('input_tanggal');
        const elHari = document.getElementById('input_hari');

        const daftarHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        function hitungHari() {
            if (elTanggal && elTanggal.value) {
                // Konversi tanggal string 'YYYY-MM-DD' tanpa terpengaruh jam/timezone
                const parts = elTanggal.value.split('-');
                if (parts.length === 3) {
                    const dt = new Date(parts[0], parts[1] - 1, parts[2]);
                    const indexHari = dt.getDay(); // 0 = Minggu, 1 = Senin, dst.
                    elHari.value = daftarHari[indexHari];
                }
            }
        }

        // Jalankan saat tanggal diubah
        if (elTanggal) {
            elTanggal.addEventListener('change', hitungHari);
            elTanggal.addEventListener('input', hitungHari);
            
            // Langsung jalankan sekali saat halaman selesai dimuat
            hitungHari();
        }
    });
</script>
@endpush
@endsection