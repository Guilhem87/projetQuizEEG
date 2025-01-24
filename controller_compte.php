<?php
//Import des Ressources
//import de la class Parent
include './controller.php';
//import des class des Views
include './view/view_compte.php';

class ControllerCompte extends Controller{
    //ATTRIBUTS
    private ?ViewCompte $compte;
    private ?ManagerUser $user;

    //CONSTRUCTEUR
    public function __construct(){
        $this->compte = new ViewCompte();
        $this->setHeader(new ViewHeader(""));
        $this->setFooter(new ViewFooter());
    }

    //GETTER ET SETTER
    public function getCompte(): ?ViewCompte { 
        return $this->compte; 
    }
    public function setCompte(?ViewCompte $compte): ControllerCompte {
        $this->compte = $compte; 
        return $this; 
    }



    public function getUser():?ManagerUser{
        return $this->user;
    }
    public function setUser(?User $newUser):?ControllerCompte{
        $this->user = $newUser;
        return $this;
    }



    //METHOD
    public function isConnect():void{
        //vérifier que quelqu'un est connecté
        if(isset($_SESSION['id_utilisateur']) && !empty($_SESSION['id_utilisateur'])){
            //J'enregistre les infos dans ma ViewCompte
            $this->getCompte()->setPseudo($_SESSION['pseudo_utilisateur']);
            $this->getCompte()->setEmail($_SESSION['email_utilisateur']);
        }else{
            //si je ne suis pas connecté, je redirige vers la page d'accueil
            header('Location:Controller_accueil.php');
            exit;
        }
    }


    public function displayUsers():void{
        //Récupération des utilisateurs en BDD
        //Je lance la fonction pour récupérer les données de mes utilisateurs
        $data = $this->getUser()->readUsers();

        //je formate l'affichage des cardUser
        ob_start();

        //Je parcours mon tableau de donné $data, pour générer l'affichage de chaque utilisateur
        foreach($data as $user){
            echo $this->getCompte()->nomUser($user);
        }

        //J'enregistre cet affichage dans la vue de l'accueil
        $this->getCompte()->setListUsers(ob_get_clean());
    }

    public function handleSessionMessages(): void {
        // Vérifie s'il y a un message de session à afficher
        if (isset($_SESSION['success_message'])) {
            $this->getHeader()->setMessage($_SESSION['success_message']);
            unset($_SESSION['success_message']); // Supprime le message pour éviter qu'il réapparaisse
        }
    }

    public function renderViews():void{
        //Je vérifie si quelqu'un est connecté
        $this->isConnect();
        
         // Gérer les messages de session
        $this->handleSessionMessages();
        
        //J'effectue le rendu de mes views
        echo $this->getHeader()->render();
        echo $this->getCompte()->render();
        echo $this->getFooter()->render();
    }
}

//Je crée l'objet ControllerCompte
$compte = new ControllerCompte();
//Je lance le rendu
$compte->renderViews();



?>