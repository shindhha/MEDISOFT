<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DrugsServices extends Model
{
    use HasFactory;
    private static $defaultDrugsServices;
    public static function getDefaultDrugsServices()
    {
        if (DrugsServices::$defaultDrugsServices == null) {
            DrugsServices::$defaultDrugsServices = new DrugsServices();
        }
        return DrugsServices::$defaultDrugsServices;
    }
    public function getMedicament($pdo,$codeCIP)
  {
    $sql = "
    SELECT 
    CIS_BDPM.codeCIS as codeCIS,
    designation,
    formePharma,
    StatutAdAMM.statutAdAMM as statutAdAMM,
    typeProc,
    autoEur,
    tauxRemboursement,
    codeCIP7,
    libellePresentation,
    statutAdminiPresentation,
    labelEtatCommercialisation,
    dateCommrcialisation,
    codeCIP13,
    agrementCollectivites,
    prix,
    IndicationRemboursement,
    labelGroupeGener,
    typeGenerique,
    numeroTri,
    labelElem,
    codesubstance,
    labelDosage,
    labelRefDosage,
    labelVoieAdministration,
    labelcondition,
    dateDebutInformation,
    dateFinInformation,
    labelTexte,
    labelTitulaire,
    dateAMM
    FROM CIS_BDPM
    LEFT JOIN DesignationElemPharma
    ON CIS_BDPM.idDesignation = DesignationElemPharma.idDesignation
    LEFT JOIN FormePharma
    ON CIS_BDPM.idFormePharma = FormePharma.idFormePharma
    LEFT JOIN StatutAdAMM
    ON CIS_BDPM.idStatutAdAMM = StatutAdAMM.idStatutAdAMM
    LEFT JOIN TypeProc
    ON CIS_BDPM.idTypeProc = TypeProc.idTypeProc
    LEFT JOIN AutorEurop
    ON CIS_BDPM.idAutoEur = AutorEurop.idAutoEur
    LEFT JOIN TauxRemboursement
    ON CIS_BDPM.codeCIS = TauxRemboursement.codeCIS
    LEFT JOIN CIS_CIP_BDPM
    ON CIS_CIP_BDPM.codeCIS = CIS_BDPM.codeCIS
    LEFT JOIN LibellePresentation
    ON CIS_CIP_BDPM.idLibellePresentation = LibellePresentation.idLibellePresentation
    LEFT JOIN EtatCommercialisation
    ON CIS_CIP_BDPM.idEtatCommercialisation = EtatCommercialisation.idEtatCommercialisation
    LEFT JOIN CIS_GENER
    ON CIS_GENER.codeCIS = CIS_BDPM.codeCIS
    LEFT JOIN GroupeGener
    ON CIS_GENER.idGroupeGener = GroupeGener.idGroupeGener
    LEFT JOIN CIS_COMPO
    ON CIS_COMPO.codeCIS = CIS_BDPM.codeCIS
    LEFT JOIN DesignationElem
    ON CIS_COMPO.idDesignationElemPharma = DesignationElem.idElem
    LEFT JOIN CodeSubstance
    ON CIS_COMPO.idCodeSubstance = CodeSubstance.idSubstance
    AND CIS_COMPO.varianceNomSubstance = CodeSubstance.varianceNom
    LEFT JOIN Dosage
    ON CIS_COMPO.idDosage = Dosage.idDosage
    LEFT JOIN RefDosage
    ON CIS_COMPO.idRefDosage = RefDosage.idRefDosage
    LEFT JOIN CIS_VoieAdministration
    ON CIS_BDPM.codeCIS = CIS_VoieAdministration.codeCIS
    LEFT JOIN ID_Label_VoieAdministration
    ON CIS_VoieAdministration.idVoieAdministration = ID_Label_VoieAdministration.idVoieAdministration
    LEFT JOIN CIS_CPD
    ON CIS_CPD.codeCIS = CIS_BDPM.codeCIS
    LEFT JOIN LabelCondition
    ON CIS_CPD.idCondition = LabelCondition.idCondition
    LEFT JOIN CIS_INFO
    ON CIS_BDPM.codeCIS = CIS_INFO.codeCIS
    LEFT JOIN Info_Texte
    ON CIS_INFO.idTexte = Info_Texte.idTexte
    LEFT JOIN CIS_Titulaires
    ON CIS_BDPM.codeCIS = CIS_Titulaires.codeCIS
    LEFT JOIN ID_Label_Titulaire
    ON CIS_Titulaires.idTitulaire = ID_Label_Titulaire.idTitulaire
    WHERE codeCIP7 = :codeCIP
    ";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam('codeCIP',$codeCIP);
    $stmt->execute();

    return $stmt->fetch();
  }
  public function getListMedic($formePharma = "%"          ,$labelVoieAdministration = "%",
                               $etatCommercialisation = -1 ,$tauxRemboursement = "",
                               $prixMin = 0                ,$prixMax = 100000,
                               $surveillanceRenforcee = -1 ,$valeurASMR = "%",
                               $libelleNiveauSMR = "%"     ,$designation = "%") 
    {
        $sql = DB::table('listMedic')->where('formePharma','like',$formePharma)
                              ->where('labelVoieAdministration','like',$labelVoieAdministration)
                              ->where('designation','like',$designation)
                              ->where('prix','>=',$prixMin)
                              ->where('prix','<=',$prixMax)
                              ->where('valeurASMR','like',$valeurASMR)
                              ->where('libelleNiveauSMR','like',$libelleNiveauSMR);
        if ($etatCommercialisation != -1) {
            $sql->where('etatCommercialisation','=',$etatCommercialisation);
        }
        if ($tauxRemboursement != "") {
            $sql->where('tauxRemboursement','=',$tauxRemboursement);
        }
        if ($surveillanceRenforcee != -1) {
            $sql->where('surveillanceRenforcee','=',$surveillanceRenforcee);
        }
        return $sql->get();
    }
}
