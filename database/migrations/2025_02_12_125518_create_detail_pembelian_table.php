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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->bigIncrements('detail_pembelian_id');
            $table->unsignedBigInteger('pembelian_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->double('harga_beli')->nullable();
            $table->integer('jumlah')->nullable();
            $table->double('sub_total')->nullable();
            $table->timestamps();

            $table->foreign('pembelian_id')->references('pembelian_id')->on('pembelian')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
