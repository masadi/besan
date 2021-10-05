<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisPembiayaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_pembiayaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yayasan_id')->constrained('yayasan');
            $table->string('nama');
            $table->foreignId('jenis_pembiayaan_id')->nullable()->constrained('jenis_pembiayaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenis_pembiayaan');
    }
}
