<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDOException;
class UsersServices extends Model
{
	use HasFactory;

	private static $defaultUsersService;
	public static function getDefaultUsersService()
	{
		if (UsersServices::$defaultUsersService == null) {
			UsersServices::$defaultUsersService = new UsersServices();
		}
		return UsersServices::$defaultUsersService;
	}
	public function findIfUserExists($login,$password)
	{
		return DB::scalar("select count(*) FROM users WHERE login = ? and `password` = MD5(?)",
			[$login,$password]);
	}



  /**
   * Modifie les instruction d'un medicament avec l'identifiant 'codeCIS'
   * pour l'ordonnance avec le numéro d'identification 'idVisite'
   *
   * @param pdo         La connexion a la base de données
   * @param idVisite    Identifiant de la visite dans la base de données
   *                    (L'identifiant d'une ordonnance est le meme que pour
   *                     celui de la visite associer)
   * @param codeCIS     Identifiant du medicament
   * @param instruction Nouvlles intructions du alter pour se medicament dans cette visite
   */
  public function editInstruction($idVisite,$codeCIP7,$instruction)
  {
  	DB::table('ordonnances')->update(['instruction' => $instruction])->where('idVisite',$idVisite)
  	                                                                 ->where('codeCIP7',$codeCIP7);
  }

  /**
   * @param pdo La connexion a la base de données
   * @return La liste des medecins de la base de données
   */
  public function getMedecins()
  {
  	return DB::table('medecins')->get();
  }



  public function getAllSMR($pdo, $codeCIP)
  {
	$sql = "
	SELECT dateAvis, libelleNiveauSMR, libelleSmr, lienPage, libelleMotifEval
	FROM CIS_HAS_SMR
	JOIN LibelleSmr LS on CIS_HAS_SMR.idLibelleSmr = LS.idLibelleSMR
	LEFT JOIN HAS_LiensPageCT HLPCT on CIS_HAS_SMR.codeHAS = HLPCT.codeHAS
	JOIN NiveauSMR NS on CIS_HAS_SMR.niveauSMR = NS.idNiveauSMR
	JOIN MotifEval ME on CIS_HAS_SMR.idMotifEval = ME.idMotifEval
	JOIN CIS_CIP_BDPM ON CIS_HAS_SMR.codeCIS = CIS_CIP_BDPM.codeCIS
	WHERE codeCIP7 = :codeCIP
	";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam('codeCIP',$codeCIP);
	$stmt->execute();

	return $stmt->fetchAll();
  }

  public function getAllASMR($pdo, $codeCIP) {
	$sql = "
	SELECT dateAvis, valeurASMR, lienPage, libelleAsmr, libelleMotifEval FROM CIS_HAS_ASMR
	LEFT JOIN HAS_LiensPageCT HLPCT on CIS_HAS_ASMR.codeHAS = HLPCT.codeHAS
	JOIN LibelleAsmr LA on CIS_HAS_ASMR.idLibelleAsmr = LA.idLibelleAsmr
	JOIN MotifEval ME on CIS_HAS_ASMR.idMotifEval = ME.idMotifEval
	JOIN CIS_CIP_BDPM CCB on CIS_HAS_ASMR.codeCIS = CCB.codeCIS
	WHERE codeCIP7 = :codeCIP
	";

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam('codeCIP',$codeCIP);
	$stmt->execute();
	return $stmt->fetchAll();
  }

	/**
   * Recherche dans la base de données les patients répondant au différents
   * critère si dessous.
   * On tire ces informations du formulaire n°
   * La recherche autorise en réalité l'inversion des nom/prenom
   * lors de la recherche.
   *                   Nom    Prenom
   * Ex :   Le patient Dupont Moretti est stocker dans la base de données
   * Si les information fournit : prenom = Dupont et nom = Moretti
   * Alors le patient sera tout de même retourner
   * Cela permet d'eviter certaine potentielles erreur de saisi
   * @param pdo             La connexion a la base de données
   * @param nom             Le nom du patient rechercher
   * @param prenom          Le prenom du patient rechercher
   * @param medecinTraitant Le alter traitant du patient rechercher
   *                        Le alter doit faire partie du cabinet
   *
   * @return L'identifiant des patients
   *         Leurs numéro de sécurités sociales
   *         Leurs lieu de naissances
   *         Leurs nom , prenom                    qui répondent aux critères
   *         Leurs date de Naissance
   *         Leurs alter traitant
   *         Leurs numéro de téléphone
   *         Leurs adresse
   */
	public function getListPatients($medecinTraitant,$nom,$prenom)
	{

		return DB::table('patients')
						->where('nom','like',$nom)
		                ->where('prenom','like',$prenom)
		                     ->where('medecinTraitant','like',$medecinTraitant)
		                     ->get();


	}

  /**
   * Ajoute le medicament avec l'identifiant 'codeCIS' avec
   * les 'instruction' ajouter par le alter à la visite avec
   * l'identifiant 'idVisite'
   * @param pdo         La connexion a la base de données
   * @param idVisite    L'identifiant de la visite
   * @param codeCIS     L'identifiant du medicament
   * @param instruction Les instructions d'utilisation du medicament
   *                    ajouter par le médecin
   */
  public function addMedic($idVisite,$codeCIP7,$instruction)
  {
  	Db::table('ordonnances')->insert(['idVisite' => $idVisite,
                                      'codeCIP7' => $codeCIP7,
                                      'instruction' => $instruction]);
  }


  /**
   * Fonctions utiliser principalement pour remplir des
   * listes déroulante pour les différents filtres
   * @param pdo    La connexion a la base de données
   * @param param  La colonne cibler dans la table
   * @param table  La table cibler dans la base de données
   * @return Une occurences de chaque valeur différentes
   *         Dans la colonne 'param' dans la table 'table'
   */
  public function getparams($param,$table)
  {
  	return Db::table($table)->select($param)->distinct()->orderBy($param)->get();
}


	/**
	 * Génère le fichier pdf représentant l'ordonnance du patient.
	 * @param $pdo
	 * @param $visite La visite dont on veut l'ordonnance
	 * @param $patient Le patient dont on veut l'ordonnance
	 * @return void
	 */
	public static function generatePdf($pdo,$visite,$patient) {
		$sql_medecin = "SELECT nom,prenom,adresse,codePostal,ville,numTel,activite
		FROM Medecins
		WHERE numRPPS = :numRPPS";
		$stmt_medecin = $pdo->prepare($sql_medecin);
		$stmt_medecin->execute(array("numRPPS" => $_SESSION['currentMedecin']));

		$medecin = $stmt_medecin->fetch();


		$sql_patient = "SELECT nom,prenom,adresse,codePostal,ville,numTel
		FROM Patients
		WHERE idPatient = :idPatient";
		$stmt_patient = $pdo->prepare($sql_patient);
		$stmt_patient->execute(array("idPatient" => $patient));

		$patient = $stmt_patient->fetch();

		$sql_medicaments = "SELECT instruction, designation, libellePresentation
		FROM Ordonnances
		JOIN CIS_CIP_BDPM ON CIS_CIP_BDPM.codeCIP7 = Ordonnances.codeCIP7
		JOIN CIS_BDPM CB ON CIS_CIP_BDPM.codeCIS = CB.codeCIS
		JOIN LibellePresentation LP on CIS_CIP_BDPM.idLibellePresentation = LP.idLibellePresentation
		JOIN DesignationElemPharma ON CB.idDesignation = DesignationElemPharma.idDesignation
		WHERE idVisite = :idVisite";
		$stmt_medicaments = $pdo->prepare($sql_medicaments);
		$stmt_medicaments->execute(array("idVisite" => $visite));
		$medicaments = $stmt_medicaments->fetchAll();

		$sql_cabinet = "SELECT adresse,codePostal,ville
		FROM Cabinet";
		$stmt_cabinet = $pdo->prepare($sql_cabinet);
		$stmt_cabinet->execute();
		$cabinet = $stmt_cabinet->fetch();

		$mpdf = new \Mpdf\Mpdf();

	// Start buffering HTML code
		ob_start();
	// Include the HTML code:
		include 'res/ordonnancetemplate.php';
	// Collect the output buffer into a variable
		$html = ob_get_contents();
	// Stop buffering
		ob_end_clean();

		$mpdf->WriteHTML($html);
	//$mpdf->Output();
		$mpdf->Output("Ordonnance.pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}
}
