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
        Schema::create('skcks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_skck')->unique();
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->string('passport')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->text('alamat');
            $table->string('pekerjaan');
            $table->string('kewarganegaraan')->default('Indonesia');
            $table->date('tanggal_masuk');
            $table->text('keperluan');
            $table->string('masa_berlaku')->default('6 Bulan');
            $table->date('tanggal_dibuat');
            $table->enum('jenis_pembayaran', ['tunai', 'online', 'online_sudah_bayar'])->default('tunai');

            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('foto_path')->nullable();
            $table->string('ttd_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skcks');
    }
};
