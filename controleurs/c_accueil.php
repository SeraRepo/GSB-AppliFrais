<?php
/**
 * Gestion de l'accueil
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Gustave JULIEN
 */

$estVisiteurConnecte = estVisiteurConnecte();
$estComptableConnecte = estComptableConnecte();

if ($estConnecte) {
    include 'vues/v_accueil.php';
} else {
    include 'vues/v_connexion.php';
}