<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuuTrusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luu_trus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dia_danh_id');
            $table->foreign('dia_danh_id')->references('id')->on('dia_danhs')->onUpdate('cascade')->onDelete('cascade');
            $table->String('tenLuuTru');
            $table->text('moTa');
            $table->text('diaChi');
            $table->text('sdt');
            $table->string('thoiGianHoatDong')->nullable();
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
        Schema::dropIfExists('luu_trus');
    }
}
