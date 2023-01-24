<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medecin extends Model
{
    use HasFactory;
    public $id = 2;
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

    function __construct($array)
    {

        if ($array != null) {
           foreach ($array as $key => $value) {
            $this->$key = $value ?: "";
            }
        } 
        
    }
}
