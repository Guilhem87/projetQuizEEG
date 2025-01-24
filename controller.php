<?php
session_start();

include "./view/header.php";
include "./view/footer.php";


class Controller{
    private ?ViewHeader $header;
    private ?ViewFooter $footer;

    public function __construct(){
        $this->header = new ViewHeader("");
        $this->footer = new ViewFooter();
    }

    public function getHeader():?ViewHeader{
        return $this->header;
    }
    public function setHeader(?ViewHeader $newHeader):Controller{
        $this->header = $newHeader;
        return $this;
    }
    public function getFooter():?ViewFooter{
        return $this->footer;
    }
    public function setFooter(?ViewFooter $newFooter):Controller{
        $this->footer = $newFooter;
        return $this;
    }

    public function renderHeader(): ?string {
          // Traite le formulaire d'inscription s'il est soumis
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $this->registerUser();
        // }
    
        // Vérifie si un utilisateur est connecté pour ajuster la navigation
        if (isset($_SESSION['id_utilisateur']) && !empty($_SESSION['id_utilisateur'])) {
            $this->getHeader()->setNav("<br><a href='controller_compte.php'>Mon Compte</a><br><a href='deconnexion.php'>Déconnexion</a>");
        }
        // verifie si l'utilisateur est un admin pour ajuster la navbar
        if (isset($_SESSION['id_role']) && $_SESSION['id_role'] === 2) {
            $this->getHeader()->setNav(
                $this->getHeader()->getNav() . "<br><a href='controller_admin.php'>Admin</a>"
            );
        }
        $this->getHeader()->setMessage('');
    
        // Rendu de la vue du header
        return $this->getHeader()->render();
    }
    

    public function renderViews():void{
        //J'effectue le rendu de mes views
        echo $this->getHeader()->render();
        echo $this->getFooter()->render();
    }
}
?>