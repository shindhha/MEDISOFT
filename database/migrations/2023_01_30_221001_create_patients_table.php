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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->char('numSecu',13)->unique();
            $table->string('LieuNaissance',200);
            $table->string('nom',25);
            $table->string('prenom',25);
            $table->date('dateNaissance');
            $table->string('adresse',100);
            $table->integer('codePostal');
            $table->string('ville',255);
            $table->char('medecinTraitant',11);
            $table->integer('numTel');
            $table->string('email',100);
            $table->text('notes');
            $table->boolean('sexe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
