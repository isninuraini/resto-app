<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('idpelanggan');
            $table->string('namapelanggan', 100);
            $table->enum('jeniskelamin', ['L', 'P']);
            $table->string('no_telp', 20);
            $table->string('alamat', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
