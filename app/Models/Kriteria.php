<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'bobot',
        'jenis',
    ];

    // public function subkriteria()
    // {
    //     return $this->hasMany(Subkriteria::class, 'id_kriteria');
    // }
}
