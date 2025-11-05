<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'idpesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'idmenu',
        'idpelanggan',
        'idmeja',
        'jumlah',
        'harga',
    ];

    // Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu');
    }

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan');
    }

    // Relasi ke Meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'idmeja');
    }

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idpesanan');
    }

    // Accessor untuk format harga
    public function getHargaRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
