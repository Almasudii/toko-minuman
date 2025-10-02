<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minuman extends Model
{
    use HasFactory;

    protected $table = 'minuman';

    protected $fillable = [
        'nama',
        'stok',
        'gambar',
        'kategori_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMinuman::class, 'kategori_id');
    }
}
