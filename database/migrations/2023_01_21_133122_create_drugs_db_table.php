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
        Schema::create('designationelems', function (Blueprint $table) {
            $table->id('idDesignation');
            $table->text('designation');
        });
        Schema::create('formepharmas', function (Blueprint $table) {
            $table->id('idFormePharma');
            $table->text('formePharma');
        });
        Schema::create('statutadamms', function (Blueprint $table) {
            $table->id('idStatutAdAMM');
            $table->string('statutAdAMM',25);
        });
        Schema::create('typeprocs', function (Blueprint $table) {
            $table->id('idTypeProc');
            $table->text('typeproc');
        });

        Schema::create('autoreurops', function (Blueprint $table) {
            $table->id('idAutoeur');
            $table->text('autoEur');
        });
        Schema::create('cis_bdpm', function (Blueprint $table) {
            $table->id('codeCIS');
            $table->unsignedBigInteger('idDesignation');
            $table->unsignedBigInteger('idFormePharma');
            $table->unsignedBigInteger('idStatutAdAMM');
            $table->unsignedBigInteger('idTypeProc');
            $table->boolean('etatCommercialisation');
            $table->date('dateAMM');
            $table->boolean('statutBdm');
            $table->unsignedBigInteger('idAutoEur');
            $table->boolean('surveillanceRenforcee');
        });
        Schema::create('tauxremboursements', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->double('autoEur',6,2);
            $table->primary(['codeCIS']);
        });
        Schema::create('libellepresentations', function (Blueprint $table) {
            $table->id('idLibellePresentation');
            $table->text('libellePresentation');
        });
        Schema::create('etatcommercialisations', function (Blueprint $table) {
            $table->id('idEtatCommercialisation');
            $table->text('labelEtatCommercialisation');
        });
        Schema::create('cis_cip_bdpm', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->integer('codeCIP7');
            $table->unsignedBigInteger('idLibellePresentation');
            $table->boolean('statutAdminiPresentation');
            $table->unsignedBigInteger('idEtatCommercialisation');
            $table->date('dateCommercialisation');
            $table->id('codeCIP13');
            $table->boolean('agrementCollectivites');
            $table->double('prix',8,2);
            $table->text('indicationRemboursement');
        });
        Schema::create('groupegeners', function (Blueprint $table) {
            $table->unsignedBigInteger('idGroupeGener');
            $table->text('labelGroupeGener');
            $table->primary(['idGroupeGener']);
        });
        Schema::create('cis_gener', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS')->primary();
            $table->unsignedBigInteger('idGroupeGener');
            $table->integer('typeGenerique');
            $table->integer('numeroTri');
        });
        Schema::create('designationelempharmas', function (Blueprint $table) {
            $table->id('idElem');
            $table->string('labelElem',100);
        });
        Schema::create('labelsubstances', function (Blueprint $table) {
            $table->integer('idSubstance');
            $table->integer('varianceNom');
            $table->text('labelSubstance');
            $table->primary(['idSubstance','varianceNom']);
        });
        Schema::create('dosages', function (Blueprint $table) {
            $table->id('idDosage');
            $table->string('labelDosage',100);
        });
        Schema::create('refdosages', function (Blueprint $table) {
            $table->id('idRefDosage');
            $table->string('labelRefDosage',100);
        });
        Schema::create('cis_compo', function (Blueprint $table) {
            $table->id('codeCIS');
            $table->unsignedBigInteger('idDesignationElemPharma');
            $table->integer('idCodeSubstance');
            $table->integer('varianceNomSubstance');
            $table->unsignedBigInteger('idDosage');
            $table->unsignedBigInteger('idRefDosage');
            $table->boolean('natureCompo');
            $table->integer('noLiaison');
        });
        Schema::create('id_label_voieadministrations', function (Blueprint $table) {
            $table->id('idVoieAdministration');
            $table->text('labelVoieAdministration');
        });
        Schema::create('cis_voieadministrations', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->unsignedBigInteger('idVoieAdministration');
            $table->primary(['codeCIS','idVoieAdministration']);
        });
        Schema::create('labelconditions', function (Blueprint $table) {
            $table->id('idCondition');
            $table->text('labelCondition');
        });
        Schema::create('cis_cpd', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->unsignedBigInteger('idCondition');
            $table->primary(['codeCIS']);
        });
        Schema::create('info_texte', function (Blueprint $table) {
            $table->id('idTexte');
            $table->text('labelTexte');
        });
        Schema::create('cis_info', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->date('dateDebutInformation');
            $table->date('DateFinInformation');
            $table->unsignedBigInteger('idTexte');
            $table->primary(['codeCIS']);
        });
        Schema::create('id_label_titulaire', function (Blueprint $table) {
            $table->id('idTitulaire');
            $table->text('labelTitulaire');
        });
        Schema::create('cis_titulaires', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->unsignedBigInteger('idTitulaire');
            $table->primary(['codeCIS','idTitulaire']);
        });
        Schema::create('libellesmr', function (Blueprint $table) {
            $table->id('idLibelleSMR');
            $table->text('libelleSmr');
        });
        Schema::create('has_lienspagect', function (Blueprint $table) {
            $table->string('codeHAS',8);
            $table->text('lienPage');
            $table->primary(['codeHAS']);
        });
        Schema::create('libelleasmr', function (Blueprint $table) {
            $table->id('idLibelleASMR');
            $table->text('libelleASMR');
        });
        Schema::create('motifeval', function (Blueprint $table) {
            $table->id('idMotifEval');
            $table->text('libelleMotifEval');
        });
        Schema::create('niveausmr', function (Blueprint $table) {
            $table->id('idNiveauSMR');
            $table->string('libelleNiveauSMR',255);
        });
        Schema::create('cis_has_smr', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->string('codeHAS',8);
            $table->unsignedBigInteger('idMotifEval');
            $table->date('dateAvis');
            $table->unsignedBigInteger('niveauSMR');
            $table->unsignedBigInteger('idLibelleSMR');
        });
        Schema::create('cis_has_asmr', function (Blueprint $table) {
            $table->unsignedBigInteger('codeCIS');
            $table->string('codeHAS',8);
            $table->unsignedBigInteger('idMotifEval');
            $table->date('dateAvis');
            $table->text('valeurASMR');
            $table->unsignedBigInteger('idLibelleASMR');
        });
        Schema::create('erreursimportations', function (Blueprint $table) {
            $table->id('idErreur');
            $table->date('dateErreur');
            $table->text('nomProcedure');
            $table->text('messageErreur');
        });

        Schema::table('cis_bdpm', function (Blueprint $table) {
            $table->foreign('idDesignation')->references('idDesignation')->on('designationelems');
            $table->foreign('idAutoEur')->references('idAutoEur')->on('autoreurops');
            $table->foreign('idFormePharma')->references('idFormePharma')->on('formepharmas');
            $table->foreign('idStatutAdAMM')->references('idStatutAdAMM')->on('statutadamms');
            $table->foreign('idTypeProc')->references('idTypeProc')->on('typeprocs'); 
        });

        Schema::table('tauxremboursements', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
        });
        Schema::table('cis_cip_bdpm', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idLibellePresentation')->references('idLibellePresentation')->on('libellepresentations');
            $table->foreign('idEtatCommercialisation')->references('idEtatCommercialisation')->on('etatcommercialisations');
        });
        Schema::table('cis_gener', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idGroupeGener')->references('idGroupeGener')->on('groupegeners');
        });
        Schema::table('cis_compo', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idDesignationElemPharma')->references('idElem')->on('designationelempharmas');
            $table->foreign(['idCodeSubstance','varianceNomSubstance'])->references(['idSubstance','varianceNom'])->on('labelsubstances');
            $table->foreign(['idRefDosage'])->references(['idRefDosage'])->on('refdosages');
            $table->foreign(['idDosage'])->references(['idDosage'])->on('dosages');
        });
        Schema::table('cis_voieadministrations', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idVoieAdministration')->references('idVoieAdministration')->on('id_label_voieadministrations');
        });
        Schema::table('cis_cpd', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idCondition')->references('idCondition')->on('labelconditions');
        });
        Schema::table('cis_info', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idTexte')->references('idTexte')->on('info_texte');
        });
        Schema::table('cis_titulaires', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('idTitulaire')->references('idTitulaire')->on('id_label_titulaire');
        });
        Schema::table('cis_has_smr', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('codeHAS')->references('codeHAS')->on('has_lienspagect');
            $table->foreign('idMotifEval')->references('idMotifEval')->on('motifeval');
            $table->foreign('idLibelleSMR')->references('idLibelleSMR')->on('libellesmr');
            $table->foreign('niveauSMR')->references('idNiveauSMR')->on('niveausmr');
        });
        Schema::table('cis_has_asmr', function (Blueprint $table) {
            $table->foreign('codeCIS')->references('codeCIS')->on('cis_bdpm');
            $table->foreign('codeHAS')->references('codeHAS')->on('has_lienspagect');
            $table->foreign('idMotifEval')->references('idMotifEval')->on('motifeval');
            $table->foreign('idLibelleASMR')->references('idLibelleASMR')->on('libelleasmr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('designationelems');
        Schema::dropIfExists('formepharmas');
        Schema::dropIfExists('statutadamms');
        Schema::dropIfExists('typeprocs');
        Schema::dropIfExists('autoreurops');
        Schema::dropIfExists('cis_bdpm');
        Schema::dropIfExists('tauxremboursements');
        Schema::dropIfExists('libellepresentations');
        Schema::dropIfExists('etatcommercialisations');
        Schema::dropIfExists('cis_cip_bdpm');
        Schema::dropIfExists('groupegeners');
        Schema::dropIfExists('cis_gener');
        Schema::dropIfExists('designationelempharmas');
        Schema::dropIfExists('labelsubstances');
        Schema::dropIfExists('dosages');
        Schema::dropIfExists('refdosages');
        Schema::dropIfExists('cis_compo');
        Schema::dropIfExists('id_label_voieadministrations');
        Schema::dropIfExists('cis_voieadministrations');
        Schema::dropIfExists('labelconditions');
        Schema::dropIfExists('cis_cpd');
        Schema::dropIfExists('info_texte');
        Schema::dropIfExists('cis_info');
        Schema::dropIfExists('id_label_titulaire');
        Schema::dropIfExists('cis_titulaires');
        Schema::dropIfExists('libellesmr');
        Schema::dropIfExists('has_lienspagect');
        Schema::dropIfExists('libelleasmr');
        Schema::dropIfExists('motifeval');
        Schema::dropIfExists('niveausmr');
        Schema::dropIfExists('cis_has_smr');
        Schema::dropIfExists('cis_has_asmr');
        Schema::dropIfExists('erreursimportations');
        Schema::enableForeignKeyConstraints();
    }
};
