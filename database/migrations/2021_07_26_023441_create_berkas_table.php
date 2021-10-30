<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->increments('id_berkas');
            $table->unsignedInteger('id_milestone');
            $table->foreign('id_milestone')->references('id_milestone')->on('milestone');
            $table->string('nama_berkas', 255);
            $table->string('file', 255);
            $table->string('keterangan', 255);
            $table->date('tgl_upload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berkas');
    }
}
