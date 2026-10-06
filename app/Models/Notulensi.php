<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulensi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function undanganMediasi()
    {
        return $this->belongsTo(UndanganMediasi::class, 'undangan_mediasi_id');
    }
}