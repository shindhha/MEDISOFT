<?php

namespace App\Http\Controllers;

use App\Models\Medecin1;
use Illuminate\Http\Request;
use App\Models\AdminServices;
use Illuminate\Support\Facades\DB;
use App\Models\settings;
use App\Models\alter;
use PDOException;
use App\Models\ImportServices;
class PostAdministrateur extends Controller
{
    private $importservice;
    private $adminServices;
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
        $this->importservice = ImportServices::getDefaultImportService();
    }
    public function index() {
        $cabinet = $this->adminServices->getInformationCabinet();
        $pageSettings = settings::getDefaultConfigAdministrateur('Administrateur');
        return view('cabinet',["cabinet" => $cabinet,"pageInfos" => $pageSettings->getSettings()]);
    }

    public function updateOrCreateCabinet(Request $request)
    {
        $this->adminServices->updateOrCreateCabinet($request->adresse,$request->codePostal,$request->ville);
        return $this->index();
    }


    public function importAll() {
        $this->importservice->prepareImport(DB::connection()->getPdo());
        foreach ($this->files as $file) {
            $filep = $file[0];
            $function = $file[1];
            $nbParam = $file[2];
            $this->importservice->download($filep);
            try {
                $importStmt = $this->importservice->constructSQL($nbParam,$function,true);
                $updateStmt = $this->importservice->constructSQL($nbParam,$function,false);
                $this->importservice->exportToBD($importStmt,$updateStmt,$file);
            } catch (PDOException $e) {
                echo $e->getMessage() . " " . $e->getCode() . " " . $e->getLine() . "<br><br>";
            }
        }
        return to_route('erreursImport');
    }





    public function goErreursImport()
    {
        $pageSettings = settings::getDefaultConfigAdministrateur('Erreurs Importations');
        $pageSettings->addIconToNavBar('/importAll','download');
        $erreursImport = $this->adminServices->getErreursImportShort();


        return view('importErrors',['erreursImport' => $erreursImport,'pageInfos' => $pageSettings->getSettings()]);
    }





}
