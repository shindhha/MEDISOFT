<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostMedicament extends Controller
{
    private $usersservices;

    public function __construct()
    {
        $this->usersservices = UsersServices::getDefaultUsersService();
    }
    public function index($pdo) {
        $view = new View("Sae3.3CabinetMedical/views/medicamentsList");
        $pformePharma = HttpHelper::getParam("pformePharma") !== null ? HttpHelper::getParam("pformePharma") : "%" ;
        $pVoieAdmi = HttpHelper::getParam("pVoieAdmi") !== null ? HttpHelper::getParam("pVoieAdmi") : "%" ;
        $pTauxRem = HttpHelper::getParam("pTauxRem") !== null ? HttpHelper::getParam("pTauxRem") : "";
        $pPrixMin = (int) HttpHelper::getParam("pPrixMin");
        $pPrixMax = (int) HttpHelper::getParam("pPrixMax") == 0 ? 10000 : (int) HttpHelper::getParam("pPrixMax");
        $pEtat =  HttpHelper::getParam("pEtat") !== null ? (int) HttpHelper::getParam("pEtat") : -1;
        $pSurveillance = HttpHelper::getParam("pSurveillance") !== null ? (int) HttpHelper::getParam("pSurveillance") : -1;
        $pNiveauSmr = HttpHelper::getParam("pNiveauSmr") !== null ?  HttpHelper::getParam("pNiveauSmr") : "%";
        $pValeurASMR = HttpHelper::getParam("pValeurASMR") !== null ?  HttpHelper::getParam("pValeurASMR") : "%";
        $pDesignation = HttpHelper::getParam("pDesignation");
        $valeurASMR = $this->usersservices->getparams($pdo,"valeurASMR","cis_has_asmr");
        $formePharmas = $this->usersservices->getparams($pdo,"formePharma","FormePharma");
        $voieAdministration = $this->usersservices->getparams($pdo,"labelVoieAdministration","ID_Label_VoieAdministration");
        $niveauSmr = $this->usersservices->getparams($pdo,"libelleNiveauSMR","niveauSmr");
        $tauxRemboursements = $this->usersservices->getparams($pdo,"tauxRemboursement","TauxRemboursement");
        $drugs = $this->usersservices->getListMedic($pdo,$pformePharma,$pVoieAdmi,$pEtat,$pTauxRem,$pPrixMin,$pPrixMax,$pSurveillance,$pValeurASMR,$pNiveauSmr,"%" . $pDesignation . "%");


        $view->setVar("pDesignation",$pDesignation);
        $view->setVar("pValeurASMR",$pValeurASMR);
        $view->setVar("pNiveauSmr",$pNiveauSmr);
        $view->setVar("niveauSmr",$niveauSmr);
        $view->setVar("valeurASMR",$valeurASMR);
        $view->setVar("pformePharma",$pformePharma);
        $view->setVar("pVoieAdmi",$pVoieAdmi);
        $view->setVar("pTauxRem",$pTauxRem);
        $view->setVar("pPrixMin",$pPrixMin);
        $view->setVar("pPrixMax",$pPrixMax);
        $view->setVar("pEtat",$pEtat);
        $view->setVar("pSurveillance",$pSurveillance);
        $view->setVar("tauxRemboursements",$tauxRemboursements);
        $view->setVar("voieAd",$voieAdministration);
        $view->setVar("formePharmas",$formePharmas);
        $view->setVar("drugs",$drugs);
        if (!isset($_SESSION['currentMedecin'])) {
            $view = new View("Sae3.3CabinetMedical/views/connection");
        }
        return $view;


    }

    public function goFicheMedicament($pdo)
    {
        $view = new View("Sae3.3CabinetMedical/views/medicament");

        $codeCIP = HttpHelper::getParam("codeCIP7");
        $medicament = $this->usersservices->getMedicament($pdo,$codeCIP);
        $lteSmr = $this->usersservices->getAllSMR($pdo,$codeCIP);
        $lteASMR = $this->usersservices->getAllASMR($pdo,$codeCIP);

        $view->setVar("medicament",$medicament);
        $view->setVar("lteSmr",$lteSmr);
        $view->setVar("lteASMR",$lteASMR);
        if (!isset($_SESSION['currentMedecin'])) {
            $view = new View("Sae3.3CabinetMedical/views/connection");
        }
        return $view;
    }
}
