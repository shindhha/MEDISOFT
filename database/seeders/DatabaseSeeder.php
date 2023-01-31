<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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
        DB::table('patients')->insert([
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
