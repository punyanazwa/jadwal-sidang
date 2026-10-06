@extends('layouts.main', ['title' => 'Daftar Putusan Perkara'])

@section('content')
<div class="card" style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px;">
        <h3 style="margin: 0; font-size: 18px; color: #1e293b;">Daftar Putusan Perkara</h3>
        <a href="{{ route('putusan.create') }}" class="btn" style="background: #0d9488; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500;">+ Input Putusan Baru</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Pencarian -->
    <form action="{{ route('putusan.index') }}" method="GET" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Perkara, Penggugat, / Tergugat..." style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; width: 300px;">
        <button type="submit" style="background: #334155; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px;">Cari</button>
        @if(request('search'))
            <a href="{{ route('putusan.index') }}" style="background: #e2e8f0; color: #334155; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center;">Reset</a>
        @endif
    </form>

    <div style="overflow-x: auto;">
        <table style="width: 100%; font-size: 14px; color: #334155; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                    <th style="padding: 12px; width: 5%;">No</th>
                    <th style="padding: 12px; width: 20%;">No. Perkara</th>
                    <th style="padding: 12px; width: 15%;">Tanggal Putusan</th>
                    <th style="padding: 12px; width: 15%;">Tanggal BHT</th>
                    <th style="padding: 12px; width: 30%;">Amar Putusan (Ringkas)</th>
                    <th style="padding: 12px; width: 15%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($putusans as $index => $item)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 12px;">{{ $index + 1 }}</td>
                        <td style="padding: 12px; font-weight: 600; color: #0d9488;">
                            {{ optional($item->perkara)->nomor_perkara ?? '-' }}
                        </td>
                        <td style="padding: 12px;">
                            {{ \Carbon\Carbon::parse($item->tanggal_putusan)->format('d-m-Y') }}
                        </td>
                        <td style="padding: 12px;">
                            {{ $item->tanggal_bht ? \Carbon\Carbon::parse($item->tanggal_bht)->format('d-m-Y') : '-' }}
                        </td>
                        <td style="padding: 12px;">
                            {{ Str::limit($item->amar_putusan, 60) }}
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="{{ route('perkara.show', $item->perkara_id) }}" style="background: #0284c7; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; margin-right: 4px;">Detail</a>
                            <form action="{{ route('putusan.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data putusan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #ef4444; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: #64748b;">Belum ada data putusan yang diinput.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection