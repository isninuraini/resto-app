<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'idmenu';

    protected $fillable = [
        'namamenu',
        'harga',
        'kategori',
        'foto',
    ];

    // Casting harga jadi integer / decimal agar query lebih aman
    protected $casts = [
        'harga' => 'integer',
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'idmenu');
    }

    // Accessor untuk format harga Rupiah
    public function getHargaRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Jika nanti kategori dipisah ke tabel terpisah
    // public function kategoriMenu()
    // {
    //     return $this->belongsTo(Kategori::class, 'kategori_id');
    // }
}
