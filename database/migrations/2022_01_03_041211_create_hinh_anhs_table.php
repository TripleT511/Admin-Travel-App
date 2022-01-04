<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHinhAnhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hinh_anhs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDiaDanh');
            $table->foreign('idDiaDanh')->references('id')->on('dia_danhs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('idBaiVietChiaSe');
            $table->integer('idLoai');
            $table->string('hinhAnh');
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
        Schema::dropIfExists('hinh_anhs');
    }
}
