@extends('layouts.main', ['title' => 'Detail Jadwal Sidang'])

@section('content')
<div class="card" style="background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; max-width: 600px; margin: 0 auto;">
    <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Detail Jadwal Sidang</h3>

    <table style="width: 100%; font-size: 14px; color: #334155; border-collapse: collapse;">
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 0; font-weight: 600; width: 35%;">No. Perkara</td>
            <td style="padding: 10px 0;">{{ optional($schedule->perkara)->nomor_perkara ?? '-' }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 0; font-weight: 600;">Penggugat</td>
            <td style="padding: 10px 0;">{{ optional($schedule->perkara)->penggugat ?? '-' }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 0; font-weight: 600;">Tergugat</td>
            <td style="padding: 10px 0;">{{ optional($schedule->perkara)->tergugat ?? '-' }}</td>
        </tr>
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 0; font-weight: 600;">Hari & Tanggal</td>
            <td style="padding: 10px 0; text-transform: capitalize;">
                {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d-m-Y') }}
            </td>
        </tr>
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 0; font-weight: 600;">Jam</td>
            <td style="padding: 10px 0;">{{ \Carbon\Carbon::parse($schedule->jam)->format('H:i') }} WIB</td>
        </tr>
        <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 0; font-weight: 600;">Agenda</td>
            <td style="padding: 10px 0;">{{ $schedule->agenda }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; font-weight: 600;">Keterangan</td>
            <td style="padding: 10px 0;">{{ $schedule->keterangan ?? '-' }}</td>
        </tr>
    </table>

    <div style="margin-top: 25px;">
        <a href="{{ url()->previous() }}" class="btn" style="background: #64748b; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; display: inline-block;">Kembali</a>
    </div>
</div>
@endsection