<?php
include("views/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'afficherFormulaire': {
		include("views/v_saisieFrais.php");
	}

	case 'ajoutFrais': {

		if(!empty($_POST['mois']) && !empty($_POST['annee'])) 
		{
			$mois = $_POST['mois'];
			$annee = $_POST['annee'];
			$date = $annee.$mois;

			
			var_dump($_POST['numero']);

			$ajout = $pdo->getAjoutFraisDate($idVisiteur, $date);
			include("views/v_saisieFraisForfait.php");
		}
	
		break;
	}

	case 'ajoutFraisForfait': {
		$HK = 
			[
				"numero" => $_POST['numero'],
				"ETP"=> $_POST["ETP"], 
				"KM"=>$_POST["KM"], 
				"NUI"=>$_POST["NUI"], 
				"REP"=> $_POST["REP"]
			];

		
		$verification = false;


		foreach ($HK as $idFraisForfait => $quantite) {
			$resultat = $pdo->getAjoutFrais($idVisiteur, $idFraisForfait, $quantite);

			$verification = true;
		}

		if($verification == true) 
		{
			include("views/v_message.php");
		}
		break;
	}
	
}
