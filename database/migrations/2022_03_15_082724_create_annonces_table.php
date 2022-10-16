<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->decimal('price',8,2);
            $table->boolean('night_work')->nullable();
            $table->time('time_start');
            $table->date('start');
            $table->time('time_end');
            $table->date('end');
            $table->boolean('valider')->nullable();
            $table->boolean('urgent')->nullable();
            $table->integer('num_candidat')->nullable();
            $table->text('desc');
            $table->foreignId('modality_id')->nullable()->references('id')->on('modalities')->onDelete('cascade');
            $table->foreignId('emp_id')->nullable()->references('id')->on('employees')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->onDelete('cascade');
            $table->foreignId('profession_id')->nullable()->references('id')->on('services')->onDelete('cascade');
            $table->foreignId('type_annonce')->nullable()->references('id')->on('type_annonces')->onDelete('cascade');
            $table->foreignId('type_structure')->nullable()->references('id')->on('types')->onDelete('cascade');
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
        Schema::dropIfExists('annonces');
    }
}
