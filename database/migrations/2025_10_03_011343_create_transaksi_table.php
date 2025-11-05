<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idtransaksi');
            $table->unsignedBigInteger('idpesanan');
            $table->date('tgl');
            $table->integer('total');
            $table->integer('bayar');
            $table->timestamps();

            $table->foreign('idpesanan')->references('idpesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
