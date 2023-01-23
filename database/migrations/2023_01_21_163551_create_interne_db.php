<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
            $table->id('idPatient');
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
        Schema::create('medecins', function (Blueprint $table) {
            $table->unsignedBigInteger('idUser');
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
        });
        Schema::create('visites', function (Blueprint $table) {
            $table->id('idVisite');
            $table->text('motifVisite');
            $table->text('Description');
            $table->text('Conclusion');
            $table->date('dateVisite');
        });
        Schema::create('listevisites', function (Blueprint $table) {
            $table->unsignedBigInteger('idVisite');
            $table->unsignedBigInteger('idPatient');
            $table->unsignedBigInteger('idMedecin');
            $table->primary(['idVisite','idPatient']);
        });
        Schema::create('cabinet', function (Blueprint $table) {
            $table->string('adresse',25);
            $table->integer('codePostal');
            $table->string('ville',255);
            $table->id();
        });
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->unsignedBigInteger('idVisite');
            $table->integer('codeCIS');
            $table->text('instruction');
            $table->primary(['idVisite','codeCIS']);
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login',11)->unique();
            $table->char('password',32);
        });

        Schema::table('medecins', function (Blueprint $table) {
            $table->foreign('idUser')->references('id')->on('users');
        });
        Schema::table('listevisites', function (Blueprint $table) {
            $table->foreign('idMedecin')->references('idMedecin')->on('medecins');
            $table->foreign('idVisite')->references('idVisite')->on('visites');
            $table->foreign('idPatient')->references('idPatient')->on('patients');
        });
        Schema::table('ordonnances', function (Blueprint $table) {
            $table->foreign('idVisite')->references('idVisite')->on('visites');
        });
        DB::table('users')->insert(
            ['login' => 'admin','password' => md5('admin')]
        );
        $userID = DB::table('users')->insertGetId(
            ['login' => '11111111111', 'password' => md5('test')]
        );
        DB::table('medecins')->insertGetId(
            ['idUser' => $userID,
             'numRPPS' => '11111111111',
             'nom' => 'Medard',
             'prenom' => 'Guillaume',
             'adresse' => '11 rue marchécal leclerc',
             'codePostal' => '12000',
             'ville' => 'Saint affrique',
             'numTel' => 785515802,
             'email' => 'guillauame.medard1@gmail.com',
             'activite' => 'Généraliste',
             'dateDebutActivites' => date('Y-m-d'),
             'dateInscription' => date('Y-m-d')   
             ]);
        DB::table('cabinet')->insert([
            'adresse' => 'Saint jean d\'alcapies',
            'codePostal' => 12250,
            'ville' => 'Saint affrique'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('patients');
        Schema::dropIfExists('medecins');
        Schema::dropIfExists('visites');
        Schema::dropIfExists('listevisites');
        Schema::dropIfExists('cabinet');
        Schema::dropIfExists('ordonnances');
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
};
