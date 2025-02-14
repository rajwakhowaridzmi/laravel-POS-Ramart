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
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('barang_id');
            $table->string('kode_barang', 50)->unique();
            $table->unsignedBigInteger('produk_id')->nullable();
            $table->string('nama_barang', 50)->nullable();
            $table->string('satuan', 10)->nullable();
            $table->double('harga_jual')->nullable();
            $table->integer('stok')->nullable();
            $table->enum('status_barang', ['0','1']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('produk_id')->on('produk')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
