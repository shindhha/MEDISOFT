<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersServices;
use App\Models\DrugsServices;
use App\Models\settings;
class PostMedicament extends Controller
{
    private $usersservices;

    public function __construct()
    {
        $this->usersservices = UsersServices::getDefaultUsersService();
        $this->drugsServices = DrugsServices::getDefaultDrugsServices();
    }
    public function index(Request $request) {
        $pformePharma = $request->pformePharma !== null ? $request->pformePharma : "%" ;
        $pVoieAdmi = $request->pVoieAdmi !== null ? $request->pVoieAdmi : "%" ;
        $pTauxRem = $request->pTauxRem !== null ? $request->pTauxRem : "";
        $pPrixMin = (int) $request->pPrixMin;
        $pPrixMax = (int) $request->pPrixMax == 0 ? 10000 : (int) $request->pPrixMax;
        $pEtat =  $request->pEtat !== null ? (int) $request->pEtat : -1;
        $pSurveillance = $request->pSurveillance !== null ? (int) $request->pSurveillance : -1;
        $pNiveauSmr = $request->pNiveauSmr !== null ?  $request->pNiveauSmr : "%";
        $pValeurASMR = $request->pValeurASMR !== null ?  $request->pValeurASMR : "%";
        $pDesignation = $request->pDesignation;
        $valeurASMR = $this->usersservices->getparams("valeurASMR","cis_has_asmr");
        $formePharmas = $this->usersservices->getparams("formePharma","FormePharmas");
        $voieAdministration = $this->usersservices->getparams("labelVoieAdministration","ID_Label_VoieAdministrations");
        $niveauSmr = $this->usersservices->getparams("libelleNiveauSMR","niveauSmr");
        $tauxRemboursements = $this->usersservices->getparams("tauxRemboursement","TauxRemboursements");
        $drugs = $this->drugsServices->getListMedic($pformePharma,$pVoieAdmi,$pEtat,$pTauxRem,$pPrixMin,$pPrixMax,$pSurveillance,$pValeurASMR,$pNiveauSmr,"%" . $pDesignation . "%");
        $pageSettings = settings::getDefaultConfigMedecin('Liste Medicaments');
        return view('medicamentsList',['pDesignation' => $pDesignation,
                                       'pValeurASMR' => $pValeurASMR,
                                       'valeurASMR' => $valeurASMR,
                                       'niveauSmr' => $niveauSmr,
                                       'pformePharma' => $pformePharma,
                                       'pVoieAdmi' => $pVoieAdmi,
                                       'pTauxRem' => $pTauxRem,
                                       'pPrixMin' => $pPrixMin,
                                       'pPrixMax' => $pPrixMax,
                                       'pEtat' => $pEtat,
                                       'pSurveillance' => $pSurveillance,
                                       'tauxRemboursements' => $tauxRemboursements,
                                       'formePharmas' => $formePharmas,
                                       'voieAdministration' => $voieAdministration,
                                       'drugs' => $drugs,
                                       'pageInfos' => $pageSettings->getSettings()]);


    }

    public function show(Request $request)
    {
        $view = new View("Sae3.3CabinetMedical/views/medicament");

        $codeCIP = $request->codeCIP7;
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
