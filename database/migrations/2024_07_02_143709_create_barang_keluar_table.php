<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarTable extends Migration
{
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id'); // Foreign key
            $table->string('nama_pembeli');
            $table->integer('jumlah');
            $table->decimal('total_transaksi', 15, 2);
            $table->decimal('biaya_tambahan', 15, 2)->nullable();
            $table->timestamps();

            // Set foreign key constraint
            $table->foreign('barang_id')->references('id_barang')->on('barang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_keluar');
    }
}