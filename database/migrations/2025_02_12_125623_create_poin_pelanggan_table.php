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
        Schema::create('poin_pelanggan', function (Blueprint $table) {
            $table->bigIncrements('poin_pelanggan_id');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->unsignedBigInteger('penjualan_id')->nullable();
            $table->double('poin_didapat')->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_pelanggan');
    }
};
