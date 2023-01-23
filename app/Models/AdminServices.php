<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDOException;
class AdminServices extends Model
{
    use HasFactory;
    private static $defaultAdminServices;

    public static function getDefaultAdminServices()
    {
        if (AdminServices::$defaultAdminServices == null) {
            AdminServices::$defaultAdminServices = new AdminServices();
        }
        return AdminServices::$defaultAdminServices;
    }

    public function updateOrCreateCabinet($adresse,$codePostal,$ville)
    {
        $cabinet = DB::table('cabinet')
                            ->where('id',1)
                            ->update(['adresse' => $adresse,
                                      'codePostal' => $codePostal,
                                      'ville' => $ville]);


    }

    public function getInformationCabinet() {
        return DB::table("cabinet")->where('id',1)->first();
    }

    public function deleteUser($userID)
    {
        BD::table('users')->where('id',$userID)->delete();
    }

    public function deleteMedecin($idMedecin)
    {
        DB::table('medecins')->where('idMedecin',$idMedecin)->delete();
        $sql = "DELETE FROM medecins WHERE idMedecin = :idMedecin";
    }
    public function updateUser($idUser,$login,$password)
    {
        DB::table('users')->where('id',$idUser)
                          ->update(['login' => $login,'password' => $password]);
    }
    /**
     * Inserer un nouvel utilisateur dans la base de données
     * avec comme identifiant de connexion 'login' 
     * (correspond au numéro RPPS du medecin)
     * et comme mot de passe 'password'
     * @param pdo      La connexion a la base de données
     * @param login    L'identifiant de connexion au site
     * @param password Le mot de connexion au site
     * @return L'identifiant fixe du medecin dans la base de données
     * 
     */
    public function addUser($login,$password)
    {
        return DB::table('users')->insertGetId(
            ['login' => $login, 'password' => $password]
        );
    }

    public function getMedecinsList()
    {
        return DB::table('medecins')->get();
    }
    /**
     * 
     * @param pdo        La connexion a la base de données
     * @param idMedecin  L'identifiant du medecin 
     * @return Dans l'odre des paramètre : 
     *         L'identifiant en tant qu'utilisateur du site 'idUser'
     *         L'identifiant en tant que medecin 'idMedecin' dans la base de données
     *         L'identifiant en tant que medecin pratiquant 'numRPPS'
     *         Son nom
     *         Son prenom
     *         Son adresse
     *         Son numéro de téléphone 
     *         Son adresse mail
     *         La date a laquelle il a été inscrit sur le site
     *         La date a laquelle il a commencer ses activités
     *         Le domaine dans le quel il pratique la medecine
     *         Son code Postal
     *         La ville où il habite
     */
    public function getMedecin($idMedecin)
    {
        return DB::table('medecins')->where('idMedecin',$idMedecin)->first();
    }

    public function updateMedecin($idMedecin, $numRPPS, $nom, $prenom, $adresse, $codePostal, $ville, $numTel, $email, $activite, $dateDebutActivites) {
        if (!preg_match("#[1-9]{11}#",$numRPPS)) {
            throw new PDOException("Le numéro de Répertoire Partagé des Professionnels intervenant dans le système de Santé (RPPS) n'est pas valide ! ", 1);
        }
        if ($dateDebutActivites == "") {
            throw new PDOException("Veuillez selectionner une date ! ",2);
        }
        DB::table('medecins')->where('idMedecin',$idMedecin)
                             ->update([
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'adresse' => $adresse,
                                'codePostal' => $codePostal,
                                'ville' => $ville,
                                'numTel' => $numTel,
                                'email' => $email,
                                'activite' => $activite,
                                'dateDebutActivites' => $dateDebutActivites,
                                'numRPPS' => $numRPPS
                             ]);
    }

    public function addMedecin($idUser ,$numRPPS, $nom, $prenom, $adresse, $codePostal, $ville, $numTel, $email, $activite, $dateDebutActivites) {
        if (!preg_match("#[1-9]{11}#",$numRPPS)) {
            throw new PDOException("Le numéro de Répertoire Partagé des Professionnels intervenant dans le système de Santé (RPPS) n'est pas valide ! ", 1);
        }
        if ($dateDebutActivites == "") {
            throw new PDOException("Veuillez selectionner une date ! ",2);
        }
        return DB::table('medecins')->insertGetId(
            ['idUser' => $idUser,
             'numRPPS' => $numRPPS,
             'nom' => $nom,
             'prenom' => $prenom,
             'adresse' => $adresse,
             'codePostal' => $codePostal,
             'ville' => $ville,
             'numTel' => $numTel,
             'email' => $email,
             'activite' => $activite,
             'dateDebutActivites' => $dateDebutActivites,
             'dateInscription' => date('Y-m-d')

        ]
        );
        
    }

    public function getErreursImportShort() {

        return DB::table('ErreursImportation')
            ->select(DB::raw('count(messageErreur) as nbreErreurs,messageErreur'))
            ->groupBy('messageErreur')
            ->orderByDesc('nbreErreurs');
    }

    
}
