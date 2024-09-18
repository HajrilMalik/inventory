<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasukTable extends Migration
{
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id'); // Foreign key
            $table->string('nama_pemasuk');
            $table->integer('stok');
            $table->timestamps();

            // Set foreign key constraint
            $table->foreign('barang_id')->references('id_barang')->on('barang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }
}