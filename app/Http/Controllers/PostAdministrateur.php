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
    private $lastDoctor;
    private $files = [["CIS_bdpm.txt","BDPM",12,false,0,"CIS_BDPM"],
                      ["CIS_CIP_bdpm.txt","CIP",13,false,4,"CIS_CIP_BDPM","codeCIP13"],
                      ["CIS_COMPO_bdpm.txt","COMPO",8,true,0,"CIS_COMPO"],
                      ["HAS_LiensPageCT_bdpm.txt","CT",2,false,0,"HAS_LiensPageCT","codeHAS"],
                      ["CIS_HAS_SMR_bdpm.txt","SMR",6,false,0,"CIS_HAS_SMR"],
                      ["CIS_HAS_ASMR_bdpm.txt","ASMR",6,false,0,"CIS_HAS_ASMR"],
                      ["CIS_GENER_bdpm.txt","GENER",5,true,2,"CIS_GENER"],
                      ["CIS_CPD_bdpm.txt","CPD",2,false,0,"CIS_CPD"],
                      ["CIS_InfoImportantes.txt","INFO",4,false,0,"CIS_INFO"]];

    public function getConfig1($name)
    {
        $pageSettings = new settings();
        $pageSettings->setTitle($name);
        $pageSettings->addIconToSideBar('/cabinet','article');
        $pageSettings->addIconToSideBar('/listMedecin','groups');
        $pageSettings->addIconToSideBar('/erreursimport','settings');
        return $pageSettings;
    }
    function __construct()
    {
        $this->adminServices = AdminServices::getDefaultAdminServices();
    }
    public function index() {
        $cabinet = $this->adminServices->getInformationCabinet();
        $pageSettings = $this->getConfig1('Administrateur');
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

    public function deleteMedecin(Request $request)
    {

        try {
            DB::beginTransaction();
            $this->adminServices->deleteMedecin($request->idMedecin);
            $this->adminServices->deleteUser($request->idUser);
            DB::commit();
        } catch (PDOException $e) {
            throw new Exception("Error Processing Request", 1);
            
            DB::rollback();
        }
        
        return to_route('doctorList');
    }

    public function goListMedecins() {
        $medecins = $this->adminServices->getMedecinsList();
        $pageSettings = new settings();
        $pageSettings = $this->getConfig1('Liste Medecins');
        return view('listdoctor',['medecins' => $medecins, "pageInfos" => $pageSettings->getSettings()]);
    }

    public function goEditDoctor($id = null,Request $request = null)
    {
        $medecin;
        if ($id === null) {
            $medecin = new medecin($request);
        } else {
            $medecin = $this->adminServices->getMedecin($id);
        }
        $pageSettings = $this->getConfig1('Edition Medecin');
        return view('editDoctor',['medecin' => $medecin , 
                                  'pageInfos' => $pageSettings->getSettings()]);
    }

    public function goDoctorSheet($id)
    {

        $this->lastDoctor = $id;
        $medecin = $this->adminServices->getMedecin($id);
        $_SESSION['idUserMedecin'] = $medecin->idUser;
        $pageSettings = $this->getConfig1('Fiche Medecin');
        return view('DoctorSheet',['id' => $this->lastDoctor,'medecin' => $medecin,'pageInfos' => $pageSettings->getSettings()]);
    }

    public function goErreursImport()
    {
        $pageSettings = $this->getConfig1('Erreurs Importations');
        $pageSettings->addIconToNavBar('/importAll','download');
        $erreursImport = $this->adminServices->getErreursImportShort();
        
        
        return view('importErrors',['erreursImport' => $erreursImport,'pageInfos' => $pageSettings->getSettings()]);
    }

    public function updateMedecin(Request $request,$id) {
        try {
            DB::beginTransaction();
            $this->adminServices->updateMedecin($id,
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
            $idUser = DB::table('medecins')->where('idMedecin',$id)->first();
            $this->adminServices->updateUser($idUser->idUser,$request->numRPPS,$request->password);
            DB::commit();
            return to_route('show',['id' => $id]);
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
            return to_route('update',['id' => $id]);
        }



        return to_route('update',['id' => $id]);

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
            
            return to_route('show',['id' => $idMedecin]);
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
            
        }

        $pageSettings = $this->getConfig1('Edition Medecin');
        
        return view('editDoctor',['medecin' => $request,'pageInfos' => $pageSettings->getSettings(),'id' => '']);

    }
}
