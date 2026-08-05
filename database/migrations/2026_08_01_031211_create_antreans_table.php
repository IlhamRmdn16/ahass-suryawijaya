<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antreans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('no_polisi');
            $table->string('tipe_motor');
            $table->dateTime('jam_masuk');
            $table->dateTime('jam_selesai')->nullable();
            $table->foreignId('mekanik_id')->nullable()->constrained('mekaniks')->nullOnDelete();
            $table->foreignId('jenis_pekerjaan_id')->constrained('jenis_pekerjaans');
            $table->string('no_hp')->nullable();
            $table->boolean('daya_auto')->default(true);
            $table->enum('status', ['menunggu', 'dikerjakan', 'selesai'])->default('menunggu');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['tanggal', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antreans');
    }
};
