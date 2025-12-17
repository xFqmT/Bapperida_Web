<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('judul');
            $table->string('pengirim');
            $table->date('tanggal_surat');
            $table->enum('status', ['kasubbang_umum', 'sekretaris', 'kepala', 'selesai', 'distribusi'])->default('kasubbang_umum');
            
            // Tanggal untuk setiap tahap workflow
            $table->dateTime('tanggal_kasubbang')->nullable();
            $table->dateTime('tanggal_sekretaris')->nullable();
            $table->dateTime('tanggal_kepala')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->dateTime('tanggal_distribusi')->nullable();
            $table->text('disposisi')->nullable()->after('tanggal_distribusi');
            
            // Indexes
            $table->index('status');
            $table->index('tanggal_surat');
            $table->index('pengirim');
            $table->index('nomor_surat');
            $table->index(['tanggal_surat', 'status']);
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
