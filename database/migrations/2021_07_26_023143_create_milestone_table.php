<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilestoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestone', function (Blueprint $table) {
            $table->increments('id_milestone');
            $table->unsignedInteger('id_proyek');
            $table->foreign('id_proyek')->references('id_proyek')->on('proyek');
            $table->string('nama_milestone', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestone');
    }
}
