<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once 'model/class.pdogsb.php';
include 'views/layout/vue_entete.php';
include 'views/layout/vue_menu.php';
require_once 'doc/fct.inc.php';
// connexion à la base de données
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
// Routeur--------------------------------
if (!isset($_REQUEST['uc'])|| !$estConnecte)
    $uc = 'connexion';
else
    $uc = $_REQUEST['uc'];

//Répartiteur-------------------------------
switch ($uc) {
    case 'connexion':
    {
        include 'controllers/c_connexion.php';
        break;
    }
    case 'etatFrais' :{
        include("controllers/c_etatFrais.php");break;
    }
    case 'saisieFrais' :{
        include("controllers/c_saisieFrais.php");break;
    }
}

include 'views/layout/vue_pied.php';
