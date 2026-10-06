<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganMediasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function notulensis()
    {
        return $this->hasMany(Notulensi::class);
    }
}