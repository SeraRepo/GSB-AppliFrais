<?php

/**
 * Controleur Valider Frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Gustave JULIEN
 */

$mois = getMois(date('d/m/Y'));
$moisPrecedent= getmoisPrecedent($mois);
$Cloture = $pdo->clotureFiche($moisPrecedent);

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'selectionnerVetM':
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $lesCles1=array_keys($lesVisiteurs);
    $visiteurASelectionner= $lesCles1[0];
    $lesMois= getLesMois($mois);
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    include  'vues/v_listesVisiteurEtMois.php';
    break;
case 'afficheFrais':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $visiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois= getLesMois($mois);
    $moisASelectionner= $leMois;
    $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    
    if (!is_array($pdo->getLesInfosFicheFrais($idVisiteur, $leMois))) { 
        ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
        include 'vues/v_erreurs.php';
        include 'vues/v_listesVisiteurEtMois.php';
    } else {
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois); 
    $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $leMois);
    include 'vues/v_afficheFrais.php';
    }
    break;
       
case 'corrigerFrais':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $leVisiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois= getLesMois($mois);
    $moisASelectionner= $leMois;
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    } 
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois); 
    $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $leMois);
    include 'vues/v_afficheFrais.php';
    break;
    
case 'corrigerFraisHF':
    $idVisiteur = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $leVisiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
    $lesMois= getLesMois($mois);
    $moisASelectionner= $leMois;
    $idFrais = filter_input(INPUT_POST, 'frais', FILTER_SANITIZE_NUMBER_INT);
    $leLibelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    $laDate = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $leMontant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
  
    valideInfosFrais($laDate, $leLibelle, $leMontant);
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->MajFraisHorsForfait($idVisiteur,$leMois,$leLibelle,$laDate,$leMontant,$idFrais);
    }    
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois); 
    $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $leMois);
    include 'vues/v_afficheFrais.php';
    break;
case 'validerFrais':
   $idVisiteur = filter_input(INPUT_POST, 'leVisiteur', FILTER_SANITIZE_STRING);
   $lesVisiteurs= $pdo->getLesVisiteurs();
   $visiteurASelectionner= $idVisiteur;
   $leMois = filter_input(INPUT_POST, 'leMois', FILTER_SANITIZE_STRING);
   $lesMois= getLesMois($mois);
   $moisASelectionner =$leMois;
   $etat="VA";
   $valideFrais=$pdo->majEtatFicheFrais($idVisiteur, $leMois, $etat);  
   $montantTotal=$pdo->montantTotal($idVisiteur,$leMois);
   $montantTotalHF=$pdo->montantTotalHorsF($idVisiteur,$leMois);
   
   if ($montantTotalHF[0][0]==null){//si il n y a pas de frais hors forfaits alors $montantTotalHF est=0
      $montantTotalHF=array();
      $montantTotalHF[0]=array(0);
   } 
   $pdo->calculMontantValide($idVisiteur,$leMois,$montantTotal,$montantTotalHF);
    ?>
    <div class="alert alert-info" role="alert">
    <p>La fiche a bien été validée!</p>
    </div>
    <?php
   include 'vues/v_listesVisiteurEtMois.php';
   break;
   
case 'supprimerFrais':
    $unIdFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $ceMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);

    $idVisiteur =filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
    ?>
    <div class="alert alert-info" role="alert">
        <p><h4>Voulez vous modifier ou supprimer le frais?<br></h4>
        <a href="index.php?uc=validerFrais&action=supprimer&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>">Supprimer</a> 
        ou <a href="index.php?uc=validerFrais&action=reporter&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>&id=<?php echo $idVisiteur ?>">Reporter</a></p>
    </div>
    <?php
    break;

case 'supprimer':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $pdo->refuserFraisHorsForfait($idFrais);
    ?>
    <div class="alert alert-info" role="alert">
        <p>Ce frais hors forfait a bien été supprimé!</p>
    </div>
    <?php
    break;

case 'reporter':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $moisSuivant= getMoisSuivant($mois);
    $idVisiteur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

    if ($pdo->estPremierFraisMois($idVisiteur, $moisSuivant)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur,$moisSuivant);
    }
    $moisAReporter=$pdo->reporterFraisHorsForfait($idFrais,$mois);   
    
    ?>
    <div class="alert alert-info" role="alert">
        <p>Ce frais hors forfait a bien été reporté au mois suivant!</p>
    </div>
     <?php
    break;
 }  





