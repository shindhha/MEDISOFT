<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visite;
use Illuminate\Http\Request;
use App\Models\UsersServices;
use App\Models\settings;
use App\Models\alter;
use Illuminate\Support\Facades\DB;
use PDOException;
use Exception;
class PostMedecin extends Controller
{
    private $usersservices;

    public function __construct()
    {
        $this->usersservices = UsersServices::getDefaultUsersService();
    }
    public function index(Request $request = null) {

        $textInput = $request != null ? explode(" ", $request->search) : "%";
        $nom = $textInput[0]?: "";
        $prenom = isset($textInput[1]) == true ? $textInput[1] : $textInput[0];
        $medecinTraitant = $request != null ? $request->medecin : "%";

        $pageSettings = settings::getDefaultConfigMedecin('Liste Patients');
        $pageSettings->setRoute('deletePatient');
        $pageSettings->addVariable('idPatient');
        $pageSettings->addText('Etes vous sur de vouloir supprimer le patient ?');
        $pageSettings->addText('Toutes ses visites seront perdue .');
        $patients = $this->usersservices->getListPatients('%',"%","%");
        $medecin = $this->usersservices->getMedecins();
        return view('listPatient',['medecins' => $medecin,'patients' => $patients, 'pageInfos' => $pageSettings->getSettings()]);
    }







    public function deleteVisite(Request $request)
    {
        $id = $request->idVisite;
        try {
            DB::beginTransaction();
            $this->usersservices->deleteVisiteFrom("Ordonnances",$id);
            $this->usersservices->deleteVisiteFrom("ListeVisites",$id);
            $this->usersservices->deleteVisiteFrom("Visites",$id);
            DB::commit();
        } catch (PDOException $e) {
            DB::rollback();
        }


        return to_route('ListMedicament');
    }



    public function goFicheVisite($id)
    {
        $visite = Visite::find($id);
        $drugs = $visite->drugs();
        $patient = $visite->patient();

        $pageSettings = settings::getDefaultConfigMedecin('Fiche Visite');

        return view('visite',['id' => $id,
                                  'drugsVisite' => $drugs,
                                  'patient' => $patient,
                                  'visite' => $visite,
                                  'pageInfos' => $pageSettings->getSettings()]);
    }

    public function goEditVisite(Request $request,$id = null)
    {
        $visite;
        if ($id === null) {
            $visite = new alter();
        } else {
            $visite = $this->usersservices->getVisite($id);
        }
        $pageSettings = settings::getDefaultConfigMedecin('Edition de visite');

        return view('editVisite',['visite' => $visite,
                                  'idPatient' => $request->idPatient,
                                  'id' => $visite->idVisite,
                                  'pageInfos' => $pageSettings->getSettings()]);
    }

    public function deleteMedicament($pdo)
    {
        $codeCIP = HttpHelper::getParam("codeCIP7");
        $this->usersservices->deleteMedicament($pdo,$_SESSION['idVisite'],$codeCIP);
        return $this->goFicheVisite($pdo);
    }

    public function updateVisite($id,Request $request)
    {

        try {
            $this->usersservices->modifVisite($id,$request->motif,$request->Date,$request->Description,$request->Conclusion);
            $view = $this->goFicheVisite($pdo);
        } catch (PDOException $e) {
            $view = $this->goEditVisite($pdo,"updateVisite");
            if ($e->getCode() == "22007") {
                $view->setVar("dateError","Veuillez sélectionner la date.");
            }
        }

        return to_route('showVisite');
    }

    public function addVisite(Request $request)
    {
        try {
            $idVisite = $this->usersservices->insertVisite($request->idPatient,$request->motifVisite,$request->Date,$request->Description,$request->Conclusion);
            return to_route('showVisite',['id' => $idVisite]);
        } catch (PDOException $e) {
            throw new PDOException();
        }
        $pageSettings = settings::getDefaultConfigMedecin('Edition de visite');
        return view('editVisite',['idPatient' => $request->idPatient,
                                  'id' => '',
                                  'visite' => $request,
                                  'pageInfos' => $pageSettings->getSettings()]);
    }

    public function addMedicament($pdo)
    {
        $codeCIP7 = HttpHelper::getParam("codeCIP7");
        $instruction = HttpHelper::getParam("instruction");

        try {
            $this->usersservices->addMedic($pdo,$_SESSION['idVisite'],(int) $codeCIP7,$instruction);
            $view = $this->goFicheVisite($pdo);
        } catch (PDOException $e) {
            $view = $this->goFicheVisite($pdo);
            $view->setVar("addMedicError","Ce médicament a déjà été ajouté !");
        }


        return $view;
    }

    public function editInstruction($pdo)
    {
        $codeCIP = HttpHelper::getParam("codeCIP7");
        $instruction = HttpHelper::getParam("instruction");
        $this->usersservices->editInstruction($pdo,$_SESSION['idVisite'],$codeCIP,$instruction);
        return $this->goFicheVisite($pdo);
    }

    public function generatePdf($pdo) {
        $visite = $_SESSION['idVisite'];
        $patient = $_SESSION['idPatient'];
        $pdf = $this->usersservices->generatePdf($pdo,$visite,$patient);

        $view = $this->goFichePatient($pdo);
        return $view;
    }
}
