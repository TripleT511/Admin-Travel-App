<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuanAnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quan_ans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dia_danh_id');
            $table->foreign('dia_danh_id')->references('id')->on('dia_danhs')->onUpdate('cascade')->onDelete('cascade');
            $table->String('tenQuan');
            $table->text('moTa');
            $table->text('diaChi');
            $table->text('sdt')->nullable();
            $table->string('thoiGianHoatDong')->nullable();
            $table->text('hinhAnh');
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
        Schema::dropIfExists('quan_ans');
    }
}
