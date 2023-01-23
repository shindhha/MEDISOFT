<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminServices;
use Illuminate\Support\Facades\DB;
use App\Models\settings;
use App\Models\medecin;
use PDOException;
class PostAdministrateur extends Controller
{
    private $importservice;
    private $adminServices;
    public $lastDoctor;
    private $files = [["CIS_bdpm.txt","BDPM",12,false,0,"CIS_BDPM"],
                      ["CIS_CIP_bdpm.txt","CIP",13,false,4,"CIS_CIP_BDPM","codeCIP13"],
                      ["CIS_COMPO_bdpm.txt","COMPO",8,true,0,"CIS_COMPO"],
                      ["HAS_LiensPageCT_bdpm.txt","CT",2,false,0,"HAS_LiensPageCT","codeHAS"],
                      ["CIS_HAS_SMR_bdpm.txt","SMR",6,false,0,"CIS_HAS_SMR"],
                      ["CIS_HAS_ASMR_bdpm.txt","ASMR",6,false,0,"CIS_HAS_ASMR"],
                      ["CIS_GENER_bdpm.txt","GENER",5,true,2,"CIS_GENER"],
                      ["CIS_CPD_bdpm.txt","CPD",2,false,0,"CIS_CPD"],
                      ["CIS_InfoImportantes.txt","INFO",4,false,0,"CIS_INFO"]];
   
    function __construct()
    {
        $this->adminServices = AdminServices::getDefaultAdminServices();
    }
    public function index() {
        $cabinet = $this->adminServices->getInformationCabinet();

        $pageSettings = new settings();
        $pageSettings->setTitle('Administrateur');
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');
        return view('cabinet',["cabinet" => $cabinet,"pageInfos" => $pageSettings->getSettings()]);
    }

    public function updateOrCreateCabinet(Request $request)
    {
        $this->adminServices->updateOrCreateCabinet($request->adresse,$request->codePostal,$request->ville);
        return $this->index();
    }


    public function importAll($pdo) {
        $view = new View("Sae3.3CabinetMedical/views/administrateur");
        $this->importservice->prepareImport($pdo);
        foreach ($this->files as $file) {
            $filep = $file[0];
            $function = $file[1];
            $nbParam = $file[2];
            $trimLine = $file[3];
            $iCis = $file[4];
            $bd = $file[5];
            $this->importservice->download($filep);
            try {
                $importStmt = $this->importservice->constructSQL($pdo,$nbParam,$function,true);
                $updateStmt = $this->importservice->constructSQL($pdo,$nbParam,$function,false);
                $test = $this->importservice->exportToBD($pdo,$importStmt,$updateStmt,$file);
            } catch (PDOException $e) {
                echo $e->getMessage() . " " . $e->getCode() . " " . $e->getLine() . "<br><br>";
            }
        }
        return $view;
    }

    public function deleteMedecin()
    {
        $idUser = $request->idUser;
        $idMedecin = $request->idMedecin;

        try {
            DB::beginTransaction();
            $this->adminServices->deleteMedecin($idMedecin);
            $this->adminServices->deleteUser($idUser);
            DB::commit();
        } catch (PDOException $e) {
            DB::rollback();
        }
        
        return $this->goListMedecins();
    }

    public function goListMedecins() {
        $medecins = $this->adminServices->getMedecinsList();
        $pageSettings = new settings();
        $pageSettings->setTitle('Liste Medecin');
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');

        return view('listdoctor',['medecins' => $medecins, "pageInfos" => $pageSettings->getSettings()]);
    }

    public function goEditDoctor($id = null,Request $request = null)
    {
        $medecin = [];
        if ($id === null) {
            $medecin = new medecin($request);
        } else {
            $medecin = $this->adminServices->getMedecin($id);
        }
        $pageSettings = new settings();
        $pageSettings->setTitle('Edition Medecin');
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');
        return view('editDoctor',['medecin' => $medecin , 
                                  'pageInfos' => $pageSettings->getSettings(), 
                                  'id' => $this->lastDoctor]);
    }

    public function goDoctorSheet($id)
    {

        $this->lastDoctor = $id;
        $medecin = $this->adminServices->getMedecin($id);
        $_SESSION['idUserMedecin'] = $medecin->idUser;
        $pageSettings = new settings();
        $pageSettings->setTitle('Fiche Medecin');
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');
        return view('DoctorSheet',['id' => $this->lastDoctor,'medecin' => $medecin,'pageInfos' => $pageSettings->getSettings()]);
    }

    public function goErreursImport()
    {
        $pageSettings = new settings();
        $pageSettings->setTitle('Erreurs importation');
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');
        $pageSettings->addIconToNavBar('/importAll','download');
        $erreursImport = $this->adminServices->getErreursImportShort();
        
        
        return view('importErrors',['erreursImport' => $erreursImport,'pageInfos' => $pageSettings->getSettings()]);
    }

    public function validForm(Request $request,$action)
    {

        $this->$action($request);
    }

    public function updateMedecin($request) {
        try {
            DB::beginTransaction();
            $this->adminServices->updateMedecin($this->lastDoctor,
                $request->numRPPS ,
                $request->nom,
                $request->prenom,
                $request->adresse,
                $request->codePostal,
                $request->ville,
                $request->numTel,
                $request->email,
                $request->activite,
                $request->dateDebutActivite
            );
            $this->adminServices->updateUser($pdo,$_SESSION['idUserMedecin'],$request->numRPPS,$request->password);
            DB::commit();
            return $this->goDoctorSheet($this->lastDoctor);
        } catch (PDOException $e) {
            DB::rollback();
            $Errors = [];
            if ($e->getCode() == "23000") {
                $Errors['numRPPS'] = ("Ce numéro RPPS est déjà utilisé ! ");
            }
            if ($e->getCode() == "HY000") {
                $Errors['email'] = ("L'adresse mail n'est pas valide ! ");
            }
            if ($e->getCode() == "1") {
                $Errors['numRPPS'] = ($e->getMessage());
            }
            if ($e->getCode() == "2") {
                $Errors['date'] = ($e->getMessage());
            }
            return $this->goEditDoctor("updateMedecin");
        }



        return view('editDoctor');

    }


    public function addMedecin(Request $request) {
        $idUserMedecin;
        $idMedecin;

        try {
            DB::beginTransaction();
             $idUserMedecin = $this->adminServices->addUser($request->numRPPS,$request->password);
             $idMedecin = $this->adminServices->addMedecin($idUserMedecin,
                $request->numRPPS ,
                $request->nom,
                $request->prenom,
                $request->adresse,
                $request->codePostal,
                $request->ville,
                $request->numTel,
                $request->email,
                $request->activite,
                $request->dateDebutActivite
            );
            DB::commit();
            $this->lastDoctor = $idMedecin;
            $_SESSION['idUserMedecin'] = $idUserMedecin;
            
            return $this->goDoctorSheet(new medecin($request),$idMedecin);
        } catch (PDOException $e) {
            DB::rollback();
            $Errors = [];
            if ($e->getCode() == "23000") {
                $Errors['numRPPS'] = ("Ce numéro RPPS est déjà utilisé ! ");
            }
            if ($e->getCode() == "HY000") {
                $Errors['email'] = ("L'adresse mail n'est pas valide ! ");
            }
            if ($e->getCode() == "1") {
                $Errors['numRPPS'] = ($e->getMessage());
            }
            if ($e->getCode() == "2") {
                $Errors['date'] = ($e->getMessage());
            }
            return redirect()->route('add');
        }
        return view('editDoctor');

    }
}
