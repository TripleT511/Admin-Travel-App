<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonAnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mon_ans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quan_an_id');
            $table->foreign('quan_an_id')->references('id')->on('quan_ans')->onUpdate('cascade')->onDelete('cascade');
            $table->String('tenMon');
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
        Schema::dropIfExists('mon_ans');
    }
}
