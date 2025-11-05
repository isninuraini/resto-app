<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'idtransaksi';

    protected $fillable = [
        'idpesanan',
        'tgl',
        'total',
        'bayar',
    ];

    protected $casts = [
        'tgl' => 'datetime',
        'total' => 'integer',
        'bayar' => 'integer',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }
}
