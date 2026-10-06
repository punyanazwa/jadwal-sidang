<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('perkara', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_perkara')->unique();
            $table->string('jenis_perkara');
            
            // Pihak-pihak (disimpan sebagai teks/JSON untuk multi-nama)
            $table->text('penggugat');
            $table->text('tergugat');
            $table->text('turut_tergugat')->nullable();
            
            // Data Pertanahan
            $table->string('sertifikat')->nullable();
            $table->text('nomor_sertifikat')->nullable(); // <-- Diubah ke TEXT agar bisa diisi banyak nomor dengan Enter
            $table->string('kecamatan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('pemegang_hak')->nullable();
            $table->string('luas')->nullable();
            
            // Surat Kuasa & Keterangan
            $table->string('no_surat_kuasa')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('penerima_kuasa')->nullable();
            $table->text('keterangan')->nullable();
            
            // Relasi ke tabel users (Menghubungkan siapa yang membuat data)
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perkara');
    }
};