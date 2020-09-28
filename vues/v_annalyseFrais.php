<?php
/**
 * Vue Accueil
 *
 * PHP Version 7
 *
* @category  PPE
 * @package   GSB
 * @author    Gustave JULIEN
 */
?>
<div id="accueil">
    <h2>
        Gestion des frais<small> - Comptable : 
            <?php 
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div>

<div id="nbFichesMontant">
	<h3>Le nombre de fiches de frais est de <a href='index.php'> </h3>
</div>

	<?php
	class PdoGsb
	{
	    private static $serveur = 'mysql:host=localhost';
	    private static $bdd = 'dbname=gsb_frais';
	    private static $user = 'userGsb';
	    private static $mdp = 'secret';
	    private static $monPdo;
	    private static $monPdoGsb = null;
	    
	    /**
	     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
	     * pour toutes les méthodes de la classe
	     */
	    private function __construct()
	    {
	        PdoGsb::$monPdo = new PDO(
	            PdoGsb::$serveur . ';' . PdoGsb::$bdd,
	            PdoGsb::$user,
	            PdoGsb::$mdp
	            );
	        PdoGsb::$monPdo->query('SET CHARACTER SET utf8');
	    }
	    
	    /**
	     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
	     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
	     */
	    public function __destruct()
	    {
	        PdoGsb::$monPdo = null;
	    }
	    
	    /**
	     * Fonction statique qui crée l'unique instance de la classe
	     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
	     *
	     * @return l'unique objet de la classe PdoGsb
	     */
	    public static function getPdoGsb()
	    {
	        if (PdoGsb::$monPdoGsb == null) {
	            PdoGsb::$monPdoGsb = new PdoGsb();
	        }
	        return PdoGsb::$monPdoGsb;
	    }
	   public function countFiches()
	   {
	    $requetePrepare = PdoGSB::$monPdo->prepare(
	        'SELECT COUNT(*), SUM(montantcvalidee)'
	        . 'FROM fichefrais'
	        );
	    $requetePrepare->execute();
	    return $requetePrepare->fetchAll();
	   }
	}
	?>