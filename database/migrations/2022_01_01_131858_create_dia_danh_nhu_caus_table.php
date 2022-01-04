<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiaDanhNhuCausTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dia_danh_nhu_caus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDiaDanh');
            $table->unsignedBigInteger('idNhuCau');
            $table->foreign('idDiaDanh')->references('id')->on('dia_danhs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('idNhuCau')->references('id')->on('nhu_caus')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('trangThai');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dia_danh_nhu_caus');
    }
}
