<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medecin extends Model
{
    use HasFactory;
    public $idMedecin = "";
    public $idPatient = "";
    public $idVisite = "";
    public $nom = "";
    public $prenom = "";
    public $numRPPS = "";
    public $adresse = "";
    public $numTel = "";
    public $email = "";
    public $dateDebutActivites = "";
    public $activite = "";
    public $codePostal = "";
    public $ville = "";
    public $lieuAct = "";
    public $medecinTraitant = "";
    public $dateNaissance = "";
    public $LieuNaissance = "";
    public $notes = "";
    public $sexe = -1;
    public $motifVisite = "";
    public $dateVisite = "";
    public $Description = "";
    public $Conclusion = "";
}
