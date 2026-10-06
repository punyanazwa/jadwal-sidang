@extends('layouts.main', ['title' => 'Data Perkara'])

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Data Perkara</h3>
        <a href="{{ route('perkara.create') }}" class="btn">+ Tambah Perkara</a>
    </div>

    <form action="{{ route('perkara.index') }}" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" class="form-control" placeholder="Cari No Perkara, Penggugat, Tergugat..." value="{{ request('search') }}" style="max-width: 350px; display: inline-block;">
        <button type="submit" class="btn" style="padding: 8px 12px;">Cari</button>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Perkara</th>
                    <th>Jenis Perkara</th>
                    <th>Penggugat</th>
                    <th>Tergugat</th>
                    <th>Turut Tergugat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($perkara as $item)
                <tr>
                    <!-- No Perkara bisa diklik untuk melihat detail -->
                    <td>
                        <a href="{{ route('perkara.show', $item->id) }}" style="color: #2563eb; text-decoration: none; font-weight: bold;">
                            {{ $item->nomor_perkara }}
                        </a>
                    </td>
                    <td>{{ $item->jenis_perkara }}</td>
                    <td style="white-space: pre-line;">{{ $item->penggugat }}</td>
                    <td style="white-space: pre-line;">{{ $item->tergugat }}</td>
                    <td style="white-space: pre-line;">{{ $item->turut_tergugat ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <!-- Tombol Edit -->
                            <a href="{{ route('perkara.edit', $item->id) }}" class="btn btn-sm" style="background: #eab308;">Edit</a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('perkara.destroy', $item->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data perkara.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection