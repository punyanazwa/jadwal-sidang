@extends('layouts.main', ['title' => 'Detail Perkara'])

@section('content')
<div class="card">
    <!-- Header / Informasi Singkat -->
    <div style="margin-bottom: 20px;">
        <span style="font-size: 13px; color: #64748b;">Berikut adalah detil dari pendaftaran perkara online yang saudara daftarkan</span>
        <h3 style="margin-top: 5px; color: #1e293b;">Nomor Perkara: {{ $perkara->nomor_perkara }}</h3>
    </div>

    <!-- Tab Navigasi ala E-Court -->
    <div style="display: flex; border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; gap: 20px;">
        <a href="#pendaftaran" class="tab-link active" onclick="switchTab(event, 'tab-pendaftaran')" style="padding: 10px 0; font-weight: 600; color: #0f766e; border-bottom: 2px solid #0f766e; text-decoration: none; margin-bottom: -2px;">Pendaftaran</a>
        <a href="#persidangan" class="tab-link" onclick="switchTab(event, 'tab-persidangan')" style="padding: 10px 0; font-weight: 600; color: #64748b; text-decoration: none;">Persidangan</a>
        <a href="#putusan" class="tab-link" onclick="switchTab(event, 'tab-putusan')" style="padding: 10px 0; font-weight: 600; color: #64748b; text-decoration: none;">Putusan</a>
    </div>

    <!-- TAB 1: PENDAFTARAN -->
    <div id="tab-pendaftaran" class="tab-content" style="display: block;">
        <div style="background: #f8fafc; padding: 20px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
            <h4 style="margin-top: 0; margin-bottom: 15px; color: #334155; font-size: 16px;">Informasi Pendaftaran Perkara</h4>
            <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0; width: 220px; color: #64748b; font-weight: 500;">Nomor Perkara</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1e293b;">{{ $perkara->nomor_perkara }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0; color: #64748b; font-weight: 500;">Jenis Perkara</td>
                    <td style="padding: 10px 0; font-weight: 600; color: #1e293b;">{{ $perkara->jenis_perkara }}</td>
                </tr>

                <!-- PENGGUGAT / PEMOHON -->
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 0; color: #64748b; font-weight: 500; vertical-align: top;">Penggugat / Pemohon</td>
                    <td style="padding: 12px 0; color: #1e293b; line-height: 1.6;">
                        @php
                            $penggugats = explode("\n", $perkara->penggugat);
                        @endphp
                        @foreach($penggugats as $key => $p)
                            @if(trim($p) !== '')
                                <div>{{ $key + 1 }}. {{ trim($p) }} <span style="font-style: italic; color: #64748b;">(Sebagai Penggugat{{ count(array_filter($penggugats)) > 1 ? ' ' . ($key + 1) : '' }})</span></div>
                            @endif
                        @endforeach
                    </td>
                </tr>

                <!-- TERGUGAT / TERMOHON -->
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 0; color: #64748b; font-weight: 500; vertical-align: top;">Tergugat / Termohon</td>
                    <td style="padding: 12px 0; color: #1e293b; line-height: 1.6;">
                        @php
                            $tergugats = explode("\n", $perkara->tergugat);
                        @endphp
                        @foreach($tergugats as $key => $t)
                            @if(trim($t) !== '')
                                <div>{{ $key + 1 }}. {{ trim($t) }} <span style="font-style: italic; color: #64748b;">(Sebagai Tergugat{{ count(array_filter($tergugats)) > 1 ? ' ' . ($key + 1) : '' }})</span></div>
                            @endif
                        @endforeach
                    </td>
                </tr>

                <!-- TURUT TERGUGAT -->
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 0; color: #64748b; font-weight: 500; vertical-align: top;">Turut Tergugat</td>
                    <td style="padding: 12px 0; color: #1e293b; line-height: 1.6;">
                        @if($perkara->turut_tergugat)
                            @php
                                $turuts = explode("\n", $perkara->turut_tergugat);
                            @endphp
                            @foreach($turuts as $key => $tt)
                                @if(trim($tt) !== '')
                                    <div>{{ $key + 1 }}. {{ trim($tt) }} <span style="font-style: italic; color: #64748b;">(Sebagai Turut Tergugat{{ count(array_filter($turuts)) > 1 ? ' ' . ($key + 1) : '' }})</span></div>
                                @endif
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>

                <!-- OBJEK PERKARA (DIGABUNG MENJADI SATU KALIMAT) -->
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 0; color: #64748b; font-weight: 500; vertical-align: top;">Objek Perkara</td>
                    <td style="padding: 12px 0; color: #1e293b; line-height: 1.6;">
                        @php
                            // Memecah baris berdasarkan enter
                            $jenisList  = array_values(array_filter(explode("\n", str_replace("\r", "", $perkara->sertifikat))));
                            $nomorList  = array_values(array_filter(explode("\n", str_replace("\r", "", $perkara->nomor_sertifikat))));
                            $luasList   = array_values(array_filter(explode("\n", str_replace("\r", "", $perkara->luas))));

                            $maxCount = max(count($jenisList), count($nomorList), count($luasList));
                            
                            // Menyusun item sertifikat ke dalam array
                            $objekItems = [];
                            for ($i = 0; $i < $maxCount; $i++) {
                                $j = trim($jenisList[$i] ?? '');
                                $n = trim($nomorList[$i] ?? '');
                                $l = trim($luasList[$i] ?? '');

                                $text = '';
                                if ($j) $text .= $j;
                                if ($n) $text .= ' ' . $n;
                                if ($l) $text .= ' Luas ' . $l . ' m²';

                                if ($text) {
                                    $objekItems[] = trim($text);
                                }
                            }

                            // Gabungkan item sertifikat dengan kata 'dan' untuk item terakhir
                            if (count($objekItems) > 1) {
                                $lastItem = array_pop($objekItems);
                                $kalimatSertifikat = implode(', ', $objekItems) . ' dan ' . $lastItem;
                            } else {
                                $kalimatSertifikat = $objekItems[0] ?? '-';
                            }
                        @endphp

                        {{ $kalimatSertifikat }}, terletak di Desa/Kelurahan {{ $perkara->desa_kelurahan ?? '-' }}, Kecamatan {{ $perkara->kecamatan ?? '-' }}, {{ $perkara->pemegang_hak ?? '-' }}.
                    </td>
                </tr>

                <!-- ATRIBUT SURAT KUASA & KETERANGAN -->
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0; color: #64748b; font-weight: 500;">No. Surat Kuasa</td>
                    <td style="padding: 10px 0; color: #1e293b;">{{ $perkara->no_surat_kuasa ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0; color: #64748b; font-weight: 500;">Tanggal Surat Kuasa</td>
                    <td style="padding: 10px 0; color: #1e293b;">{{ $perkara->tanggal ? \Carbon\Carbon::parse($perkara->tanggal)->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0; color: #64748b; font-weight: 500;">Penerima Kuasa</td>
                    <td style="padding: 10px 0; color: #1e293b;">{{ $perkara->penerima_kuasa ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #64748b; font-weight: 500;">Keterangan</td>
                    <td style="padding: 10px 0; color: #1e293b;">{{ $perkara->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- TAB 2: PERSIDANGAN -->
    <div id="tab-persidangan" class="tab-content" style="display: none;">
        <div style="background: #fef08a; padding: 12px 15px; border-radius: 6px; margin-bottom: 15px; font-weight: 600; color: #713f12; font-size: 14px;">
            COURT CALENDAR / RENCANA PERSIDANGAN NOMOR : {{ $perkara->nomor_perkara }}
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;" border="1" cellpadding="10" bordercolor="#e2e8f0">
                <thead>
                    <tr style="background: #f1f5f9; text-align: left; color: #334155;">
                        <th style="width: 50px; text-align: center;">No.</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Agenda/Acara Sidang</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perkara->schedules as $index => $schedule)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td>{{ $schedule->jam }}</td>
                        <td>{{ $schedule->agenda }}</td>
                        <td>{{ $schedule->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">Belum ada jadwal persidangan untuk perkara ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB 3: PUTUSAN -->
    <div id="tab-putusan" class="tab-content" style="display: none;">
        @if($perkara->putusan)
            <div style="background: #0f766e; padding: 12px 15px; border-radius: 6px; margin-bottom: 15px; font-weight: 600; color: #ffffff; font-size: 14px;">
                INFORMASI PUTUSAN PERKARA NOMOR : {{ $perkara->nomor_perkara }}
            </div>

            <div style="background: #f8fafc; padding: 20px; border-radius: 6px; border: 1px solid #e2e8f0;">
                <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 0; width: 220px; color: #64748b; font-weight: 500;">Tanggal Putusan</td>
                        <td style="padding: 12px 0; font-weight: 600; color: #1e293b;">
                            {{ \Carbon\Carbon::parse($perkara->putusan->tanggal_putusan)->translatedFormat('l, d F Y') }}
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 0; color: #64748b; font-weight: 500;">Tanggal BHT (Berkekuatan Hukum Tetap)</td>
                        <td style="padding: 12px 0; font-weight: 600; color: #1e293b;">
                            {{ $perkara->putusan->tanggal_bht ? \Carbon\Carbon::parse($perkara->putusan->tanggal_bht)->translatedFormat('l, d F Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; color: #64748b; font-weight: 500; vertical-align: top;">Amar Putusan</td>
                        <td style="padding: 12px 0; color: #1e293b; line-height: 1.6;">
                            {!! nl2br(e($perkara->putusan->amar_putusan)) !!}
                        </td>
                    </tr>
                </table>
            </div>
        @else
            <div style="background: #f8fafc; padding: 40px; text-align: center; border-radius: 6px; border: 1px solid #e2e8f0; color: #64748b;">
                <p style="margin: 0; font-size: 15px;">Belum ada data putusan atau perkara masih berjalan.</p>
            </div>
        @endif
    </div>

    <!-- Tombol Kembali -->
    <div style="margin-top: 25px;">
        <a href="{{ route('perkara.index') }}" class="btn" style="background: #64748b; text-decoration: none; color: white; padding: 8px 16px; border-radius: 4px; display: inline-block;">Kembali ke Daftar Perkara</a>
    </div>
</div>

<!-- Script untuk Tab -->
<script>
    function switchTab(event, tabId) {
        event.preventDefault();
        
        // Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
        
        // Hapus kelas aktif dari semua tombol tab
        document.querySelectorAll('.tab-link').forEach(el => {
            el.style.color = '#64748b';
            el.style.borderBottom = 'none';
            el.style.marginBottom = '0';
        });
        
        // Tampilkan tab yang dipilih
        document.getElementById(tabId).style.display = 'block';
        
        // Beri style aktif ke tombol yang diklik
        event.currentTarget.style.color = '#0f766e';
        event.currentTarget.style.borderBottom = '2px solid #0f766e';
        event.currentTarget.style.marginBottom = '-2px';
    }
</script>
@endsection