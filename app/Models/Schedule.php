<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'perkara_id',
        'hari',
        'tanggal',
        'jam',
        'agenda',
        'keterangan',
    ];

    // Relasi ke tabel CaseModel (Perkara)
    public function perkara()
    {
        return $this->belongsTo(CaseModel::class, 'perkara_id');
    }
}