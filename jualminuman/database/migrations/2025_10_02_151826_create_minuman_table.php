<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('minuman', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();

            // Relasi ke tabel kategoriminuman
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoriminuman')
                  ->onDelete('cascade'); // jika kategori dihapus, minuman ikut terhapus

            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('minuman');
    }
};
