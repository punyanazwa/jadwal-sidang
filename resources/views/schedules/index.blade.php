@extends('layouts.main', ['title' => 'Data Jadwal Sidang'])

@section('content')
<div class="card" style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px;">
    <!-- Header Tabel & Tombol Tambah -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1e293b;">Daftar Jadwal Sidang</h3>
        <a href="{{ route('schedules.create') }}" class="btn" style="background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px;">+ Tambah Jadwal Sidang</a>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Filter Rentang Tanggal & Tombol Cetak -->
    <form method="GET" action="{{ route('schedules.index') }}" style="background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px; display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 180px;">
            <label for="tanggal_mulai" style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 600; color: #334155;">Dari Tanggal</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        <div style="flex: 1; min-width: 180px;">
            <label for="tanggal_selesai" style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 600; color: #334155;">Sampai Tanggal</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <button type="submit" class="btn" style="background: #0f766e; color: white; padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">Filter</button>
            <a href="{{ route('schedules.index') }}" class="btn" style="background: #64748b; color: white; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-block;">Reset</a>
            
            <!-- Tombol Print sesuai filter tanggal -->
            <a href="{{ route('schedules.print', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}" target="_blank" class="btn" style="background: #2563eb; color: white; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-block;">🖨️ Cetak</a>
        </div>
    </form>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 14px;">
                    <th style="padding: 12px 10px; width: 5%;">No</th>
                    <th style="padding: 12px 10px; width: 20%;">No. Perkara</th>
                    <th style="padding: 12px 10px; width: 18%;">Hari & Tanggal</th>
                    <th style="padding: 12px 10px; width: 10%;">Jam</th>
                    <th style="padding: 12px 10px; width: 18%;">Agenda</th>
                    <th style="padding: 12px 10px; width: 17%;">Keterangan</th>
                    <th style="padding: 12px 10px; width: 12%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $item)
                <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155;">
                    <td style="padding: 12px 10px; vertical-align: top;">
                        {{ method_exists($schedules, 'firstItem') ? $schedules->firstItem() + $index : $index + 1 }}
                    </td>
                    
                    <td style="padding: 12px 10px; vertical-align: top; font-weight: 600; color: #1e293b;">
                        {{ optional($item->perkara)->nomor_perkara ?? '-' }}
                    </td>

                    <td style="padding: 12px 10px; vertical-align: top;">
                        <div style="text-transform: capitalize;">{{ $item->hari }}</div>
                        <div style="font-size: 13px; color: #64748b;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</div>
                    </td>

                    <td style="padding: 12px 10px; vertical-align: top;">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</td>
                    
                    <td style="padding: 12px 10px; vertical-align: top;">
                        <span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 13px; color: #334155;">
                            {{ $item->agenda }}
                        </span>
                    </td>

                    <td style="padding: 12px 10px; vertical-align: top; color: #64748b; font-size: 13px;">
                        {{ $item->keterangan ?? '-' }}
                    </td>

                    <td style="padding: 12px 10px; vertical-align: top;">
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <a href="{{ route('schedules.edit', $item->id) }}" class="btn btn-warning btn-sm" style="background: #f59e0b; color: white; border: none; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">Edit</a>

                            <form action="{{ route('schedules.destroy', $item->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="return confirm('Yakin ingin menghapus jadwal sidang ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 30px;">Belum ada data jadwal sidang yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (Hanya muncul jika tidak dalam mode filter tanggal) -->
    @if(method_exists($schedules, 'links'))
        <div style="margin-top: 20px;">
            {{ $schedules->links() }}
        </div>
    @endif
</div>
@endsection