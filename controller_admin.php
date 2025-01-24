<?php

//import des includes
include './controller.php';
include './view/view_admin.php';


class ControllerAdmin extends Controller {

    private ?ViewAdmin $viewAdmin;

    private ?ManagerUser $user;

    public function __construct(){
        $this->viewAdmin = new ViewAdmin();
        $this->setHeader(new ViewHeader("<a href='deconnexion.php'>Déconnexion</a>"));
        $this->setFooter(new ViewFooter());
    }

//GETTER SETTER

    public function getViewAdmin(): ViewAdmin {
        return $this->viewAdmin;
    }
    public function getUser(): ?ManagerUser {
        return $this->user;
    }


    public function setViewAdmin(ViewAdmin $newViewAdmin){
        $this->viewAdmin = $newViewAdmin;
        return $this;
    }
    public function setUser(?ViewAdmin $newUser):?ControllerAdmin{
        $this->user = $newUser;
        return $this;
    }

    //METHODE 

    public function handleSessionMessages(): void {
        // Vérifie s'il y a un message de session à afficher
        if (isset($_SESSION['success_message'])) {
            $this->getHeader()->setMessage($_SESSION['success_message']);
            unset($_SESSION['success_message']); // Supprime le message pour éviter qu'il réapparaisse
        }
    }

    public function isAdmin():void{
    }

    public function renderViews():void{
        //Je vérifie si quelqu'un est connecté
        $this->isAdmin();

        // Gérer les messages de session
        $this->handleSessionMessages();
        //J'effectue le rendu de mes views
        echo $this->getHeader()->render();
        echo $this->getViewAdmin()->render();
        echo $this->getFooter()->render();
    }
    }

$viewAdmin = new ControllerAdmin();

$viewAdmin->renderViews();

