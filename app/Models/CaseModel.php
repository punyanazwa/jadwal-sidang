<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    use HasFactory;

    protected $table = 'perkara';

    protected $fillable = [
        'nomor_perkara',
        'jenis_perkara',
        'penggugat',
        'tergugat',
        'turut_tergugat',
        'sertifikat',
        'nomor_sertifikat',
        'kecamatan',
        'desa_kelurahan',
        'pemegang_hak',
        'luas',
        'no_surat_kuasa',
        'tanggal',
        'penerima_kuasa',
        'keterangan',
        'dibuat_oleh',
    ];

    // Relasi ke Jadwal Sidang (Schedules)
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'perkara_id');
    }

    // RELASI KE PUTUSAN (PENTING AGAR TERHUBUNG)
    public function putusan()
    {
        return $this->hasOne(Putusan::class, 'perkara_id');
    }
}