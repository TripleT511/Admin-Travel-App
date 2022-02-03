<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeXuatDiaDanhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('de_xuat_dia_danhs', function (Blueprint $table) {
            $table->id();
            $table->string('tenDiaDanh');
            $table->text('moTa');
            $table->double('kinhDo');
            $table->double('viDo');
            $table->unsignedBigInteger('tinh_thanh_id');
            $table->foreign('tinh_thanh_id')->references('id')->on('tinh_thanhs')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('hinhAnh');
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
        Schema::dropIfExists('de_xuat_dia_danhs');
    }
}
