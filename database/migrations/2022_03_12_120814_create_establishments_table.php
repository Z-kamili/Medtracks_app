<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('sirt_num')->nullable();
            $table->foreignId('type_id')->nullable()->references('id')->on('types')->onDelete('cascade');
            $table->foreignId('id_city')->nullable()->references('id')->on('cities')->onDelete('cascade');
            $table->string('adress')->nullable();
            $table->string('desc')->nullable();
            $table->integer('dep')->nullable();
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
        Schema::dropIfExists('establishments');
    }
}
