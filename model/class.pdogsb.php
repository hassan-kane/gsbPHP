<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsbfrais';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
    /**
     * Retourne les informations d'un visiteur

     * @param $login
     * @param $mdp
     * @return l'id, le nom et le pr�nom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login, $mdp){
        $req = "select id, nom, prenom from visiteur where login='$login' and mdp='$mdp'";
        $rs = PdoGsb::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }
    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
     * concern�es par les deux arguments

     * La boucle foreach ne peut �tre utilis�e ici car on proc�de
     * � une modification de la structure it�r�e - transformation du champ date-

     * @param $idVisiteur
     * @param $mois sous la forme aaaamm
     * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur,$mois){
        $req = "select * from lignefraishorsforfait where idvisiteur ='$idVisiteur' 
		and mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i=0; $i<$nbLignes; $i++){
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }



    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais

     * @param $idVisiteur
     * @return un tableau associatif de cl� un mois -aaaamm- et de valeurs l'ann�e et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur){
        $req = "select mois from  fichefrais where idvisiteur ='$idVisiteur' order by mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois =array();
        $laLigne = $res->fetch();
        while($laLigne != null)	{
            $mois = $laLigne['mois'];
            $numAnnee =substr( $mois,0,4);
            $numMois =substr( $mois,4,2);
            $lesMois["$mois"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
                "numMois"  => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }
    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donn�

     * @param $idVisiteur
     * @param $mois sous la forme aaaamm
     * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'�tat
     */
    public function getLesInfosFicheFrais($idVisiteur,$mois){
        $req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
			fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
			where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
    }

    public function getAjoutFraisDate($date, $idVisiteur) {

        $bd = PdoGsb::$monPdo->prepare("INSERT INTO fichefrais(`idVisiteur`, `mois`) VALUES(:idVisiteur, :mois)");
    
        $bd-> bindparam(':idVisiteur',$idVisiteur);
        $bd-> bindparam(':mois',$date);
        $bd->execute();

       
    }

    public function getAjoutFrais($idFraisForfait, $quantite) {
        // $sql = "INSERT INTO `lignefraisforfait`(`idFraisForfait`, `quantite`) VALUES ('$idFraisForfait','$quantite')";
        // // PdoGsb::$monPdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        // $req = PdoGsb::$monPdo->prepare($sql); 

        // $req->execute(); 
        // // print_r($req->errorInfo());

        // // var_dump($req);

        $bd = PdoGsb::$monPdo->prepare("INSERT INTO `lignefraisforfait`(`idVisiteur`, `idFraisForfait`, `quantite`) VALUES(:idVisiteur, :idFraisForfait, :quantite)");

        $bd-> bindparam(':idVisiteur',$idVisiteur);
        $bd-> bindparam(':idFraisForfait',$idFraisForfait);
        $bd-> bindparam(':quantite',$quantite);
        $bd->execute();

    }

    
}


    // $bd = $pdo->prepare("INSERT INTO fichefrais(`mois`, `idVisiteur`) VALUES(:idVisiteur, :mois, :srcTournoi)");
    
    // $bd-> bindparam(':idVisiteur',$idVisiteur);
    // $bd-> bindparam(':mois',$annee$mois);
    
	// $bd->execute();

