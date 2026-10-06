<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('putusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perkara_id')->constrained('perkara')->onDelete('cascade');
            $table->date('tanggal_putusan');
            $table->date('tanggal_bht')->nullable();
            $table->text('amar_putusan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('putusan');
    }
};