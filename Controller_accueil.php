<?php

// Inclusion des fichiers nécessaires
include './App/Utils/Bdd.php';
include './controller.php';  // Contrôleur de base
include './App/Model/User.php';  // Modèle User
include './manager/manager_users.php';  // Gestionnaire des utilisateurs
include './view/view_accueil.php';  // Vue d'accueil
include './view/view_connexion.php';  // Vue de la popup de connexion
include './view/view_inscription.php';  // Vue de la popup d'inscription


class ControllerAccueil extends Controller {
    private ?ManagerUser $userManager;
    private ?ViewAccueil $accueil;
    private ?ViewConnexion $connexionPopup;
    private ?ViewInscription $inscriptionPopup;

    public function __construct() {
        $this->userManager = new ManagerUser(connect());
        $this->accueil = new ViewAccueil();
        $this->connexionPopup = new ViewConnexion();
        $this->inscriptionPopup = new ViewInscription();
        $this->setHeader(new ViewHeader("<a href='#' data-popup-target='loginPopupOverlay'>Connexion</a><br><a href='#' data-popup-target='registerPopupOverlay'>Inscription</a>"));
        $this->setFooter(new ViewFooter());
    }

    public function displayUsers(): void {
        $data = $this->userManager->readUsers();  // Lecture des utilisateurs
        ob_start();
        foreach ($data as $user) {
            echo $this->accueil->cardUser($user);
        }
        $this->accueil->setListUsers(ob_get_clean());
    }

    public function renderViews(): void {

        // Affichage des utilisateurs
        // $this->displayUsers();

        $this->getFooter()->setMessage($this->getHeader()->getMessage());
        $this->getHeader()->setMessage($this->getHeader()->getMessage());
        
        
        echo $this->renderHeader();
        echo $this->connexionPopup->render();
        echo $this->inscriptionPopup->render();
        echo $this->accueil->render();
        echo $this->getFooter()->render();
    }
}


// Création du controller
$accueil = new ControllerAccueil();
// Lancement du rendu
$accueil->renderViews();


?>