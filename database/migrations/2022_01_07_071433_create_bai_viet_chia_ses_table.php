<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaiVietChiaSesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bai_viet_chia_ses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDiaDanh');
            $table->foreign('idDiaDanh')->references('id')->on('dia_danhs')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('noiDung');
            $table->dateTime('thoiGian');
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
        Schema::dropIfExists('bai_viet_chia_ses');
    }
}
