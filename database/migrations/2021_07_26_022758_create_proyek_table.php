<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->increments('id_proyek');
            $table->string('nomor_proyek', 255);
            $table->string('nama_proyek', 255);
            $table->string('lokasi', 255);
            $table->string('dinas', 255);
            $table->string('thn_anggaran', 4);
            $table->string('harga', 255);
            $table->date('tgl_mulai_proyek');
            $table->date('tgl_selesai_proyek');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyek');
    }
}
