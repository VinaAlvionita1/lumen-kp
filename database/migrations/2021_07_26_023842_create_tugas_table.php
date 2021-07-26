<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->increments('id_tugas');
            $table->unsignedInteger('id_status');
            $table->foreign('id_status')->references('id_status')->on('status');
            $table->unsignedInteger('id_kategori');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
            $table->unsignedInteger('id_karyawan');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan');
            $table->unsignedInteger('id_milestone');
            $table->foreign('id_milestone')->references('id_milestone')->on('milestone');
            $table->string('nama_tugas', 255);
            $table->string('keterangan_tugas', 255);
            $table->date('tgl_mulai_tugas');
            $table->date('tgl_selesai_tugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas');
    }
}
