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
        Schema::create('pkbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrean_id')->unique()->constrained('antreans')->cascadeOnDelete();
            $table->string('nama_konsumen');
            $table->boolean('setuju_1')->default(false);
            $table->boolean('setuju_2')->default(false);
            $table->string('tanda_tangan')->nullable();
            $table->timestamp('ditandatangani_pada')->nullable();
            $table->string('no_pkb')->nullable();
            $table->foreignId('diisi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diisi_pada')->nullable();
            $table->enum('status', ['menunggu_ttd', 'menunggu_no_pkb', 'selesai'])->default('menunggu_ttd');

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkbs');
    }
};
