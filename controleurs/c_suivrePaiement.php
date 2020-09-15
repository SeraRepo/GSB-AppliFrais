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
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
case 'selectionnerVetM':
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $lesCles1=array_keys($lesVisiteurs);
    $visiteurASelectionner= $lesCles1[0];
    $lesMois= $pdo->getLesMoisVA();
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    include  'vues/v_listesVisiteurEtMois.php';
    break;
case 'afficheFrais':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $visiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois= $pdo->getLesMoisVA();
    $moisASelectionner= $leMois;

    $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    
    if (!is_array($pdo->getLesInfosFicheFrais($idVisiteur, $leMois))) { 
        ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
        include 'vues/v_erreurs.php';
        include 'vues/v_listesVisiteurEtMois.php';
    } else {
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois); 
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_etatFrais.php';
    }
    break;

case 'rembourserFrais':
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs= $pdo->getLesVisiteurs();
    $visiteurASelectionner= $idVisiteur;
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois= $pdo->getLesMoisVA();
    $moisASelectionner= $leMois;   
    $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    
    if (!is_array($pdo->getLesInfosFicheFrais($idVisiteur, $leMois))) { 
        ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
        include 'vues/v_erreurs.php';
        include 'vues/v_listesVisiteurEtMois.php';
        
    } else {       
    $libEtat = $lesInfosFicheFrais['libEtat'];
    
        if($libEtat== 'Validée et mise en paiement'){
            $rembourser = $pdo->rembourserFiche($idVisiteur,$leMois);
        }   
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois); 
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_etatFrais.php';
    } 
    break;
}