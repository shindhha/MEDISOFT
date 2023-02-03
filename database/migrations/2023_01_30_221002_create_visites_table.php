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
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->text('motifVisite');
            $table->text('Description');
            $table->text('Conclusion');
            $table->date('dateVisite');
            $table->unsignedBigInteger('patient_id');
            $table->char('doctor_id',11)->default('11111111111');

            $table->foreign('doctor_id')->references('numRPPS')->on('medecins');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visites');
    }
};
