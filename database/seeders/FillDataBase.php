<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FillDataBase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userID = Seeder::table('users')->insertGetId(
            ['login' => '11111111111', 'password' => md5('test')]
        );
        Seeder::table('medecins')->insertGetId(
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
        Seeder::table('cabinet')->insert([
            'adresse' => 'Saint jean d\'alcapies',
            'codePostal' => 12250,
            'ville' => 'Saint affrique'
        ]);
        Seeder::table('patients')->insert([
            'numSecu' => '1111111111111',
            'LieuNaissance' => 'Millau',
            'nom' => 'Medard',
            'prenom' => 'Guillaume',
            'dateNaissance' => date('Y-m-d'),
            'adresse' => 'Saint Jean d alcapies',
            'codePostal' => 12000,
            'ville' => 'Rodez',
            'medecinTraitant' => '11111111111',
            'numTel' => 785515802,
            'email' => 'guillaume.medard1@gmail.com',
            'notes' => '',
            'sexe' => 1
        ]);
    }
}
