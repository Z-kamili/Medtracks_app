<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnnonceProfessional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annonce_professional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->nullable()->references('id')->on('professionals')->onDelete('cascade');
            $table->foreignId('annonce_id')->nullable()->references('id')->on('annonces')->onDelete('cascade');
            $table->unique(['professional_id','annonce_id']);
            $table->boolean('valider')->nullable();
            $table->dateTime('finished_at')->nullable();
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
        Schema::dropIfExists('annonce_professional');
    }
}
