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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('detail_penjualan_id');
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->double('harga_jual')->nullable();
            $table->integer('jumlah')->nullable();
            $table->double('sub_total')->nullable();
            $table->timestamps();

            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
