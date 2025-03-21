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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->bigIncrements('pengajuan_id');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_barang', 255)->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->enum('status', ['0', '1'])->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
