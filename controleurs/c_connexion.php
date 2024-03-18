<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $visiteur = $pdo->getInfosVisiteur($login, $mdp);
    if (!is_array($visiteur)) {
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    } else {
        $id = $visiteur['id'];
        $nom = $visiteur['nom'];
        $prenom = $visiteur['prenom'];
        $role = $visiteur['role'];
        connecter($id, $nom, $prenom, $role);
        header('Location: index.php');
    }
    break;
case 'inscription':
    require 'vues/v_inscription.php';
    break;
case 'valideInscription' :
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        $adresse = $_POST['adresse'];            
        $cp = $_POST['cp'];
        $ville = $_POST['ville'];
        $dateEmbauche = $_POST['dateEmbauche'];
        $role = $_POST['role'];
        
        $newUser = [
            "id"=> ($_POST['id']),
            "nom" => ($_POST['nom']),
            "prenom" => ($_POST['prenom']),
            "login" => ($_POST['login']),
            "mdp" => ($_POST['mdp']),
            "adresse" => ($_POST['adresse']),
            "cp" => ($_POST['cp']),
            "ville" => ($_POST['ville']),
            "dateEmbauche" => ($_POST['dateEmbauche']),
            "role" => ($_POST['role']),
        ];
        var_dump($newUser);
        $insert = $pdo->insertNewUser($newUser);
        connecter($id, $nom, $prenom, $role);
    require 'vues/v_accueil.php';
    break;
default:
    include 'vues/v_connexion.php';
    break;
}
