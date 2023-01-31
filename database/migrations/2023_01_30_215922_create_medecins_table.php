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
        Schema::create('medecins', function (Blueprint $table) {

            $table->id('idMedecin');
            $table->char('numRPPS',11)->unique();
            $table->string('nom',25);
            $table->string('prenom',25);
            $table->date('dateInscription');
            $table->date('dateDebutActivites');
            $table->string('adresse',100);
            $table->integer('codePostal');
            $table->string('ville',255);
            $table->integer('numTel');
            $table->string('email',100);
            $table->string('activite');

            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medecins');
    }
};
