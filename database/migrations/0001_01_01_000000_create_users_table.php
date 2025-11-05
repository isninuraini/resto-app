<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('iduser');
            $table->string('namauser');
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['administrator', 'waiter', 'kasir', 'owner'])->default('waiter');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
