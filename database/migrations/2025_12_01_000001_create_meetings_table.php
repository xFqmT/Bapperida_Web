<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('agenda');
            $table->string('pic');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->enum('status', ['scheduled','ongoing','done'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->enum('ruang_rapat', ['Ibdis', 'LT1', 'LT2'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
