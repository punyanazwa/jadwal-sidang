<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Putusan extends Model
{
    use HasFactory;

    protected $table = 'putusan';

    protected $fillable = [
        'perkara_id',
        'tanggal_putusan',
        'tanggal_bht',
        'amar_putusan',
    ];

    public function perkara()
    {
        return $this->belongsTo(CaseModel::class, 'perkara_id');
    }
}