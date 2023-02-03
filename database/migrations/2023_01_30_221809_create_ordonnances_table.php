<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordonnances', function (Blueprint $table) {

            $table->integer('codeCIP7');
            $table->text('instruction');
            $table->primary(['visite_id','codeCIP7']);


            $table->unsignedBigInteger('visite_id');
            $table->foreign('visite_id')->references('id')->on('visites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordonnances');
    }
};
