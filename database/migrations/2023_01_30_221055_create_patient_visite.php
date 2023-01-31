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
        Schema::create('listevisites', function (Blueprint $table) {
            $table->unsignedBigInteger('idVisite');
            $table->unsignedBigInteger('idPatient');
            $table->unsignedBigInteger('idMedecin')->default(11111111111);
            $table->primary(['idVisite','idPatient']);

            $table->foreign('idMedecin')->references('idMedecin')->on('medecins');
            $table->foreign('idVisite')->references('idVisite')->on('visites');
            $table->foreign('idPatient')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_visite');
    }
};
