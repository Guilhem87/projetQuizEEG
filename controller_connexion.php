<?php
//FORMATEUR:IMPORT DES RESSOURCES
//YD:Import de la classe parent
include './controller.php';
//Import des ressources nécessaire
include './App/Utils/Bdd.php';
include './App/Model/User.php';
include './manager/manager_users.php';
//YD:INCLUDE DE MES VUES
include './view/view_connexion.php';

class ControllerConnexion extends Controller{
    //ATTRIBUTS
    private ?User $user;
    private ?ViewConnexion $connexion;

    //CONSTRUCTEUR
    public function __construct(){
        $this->user = new ManagerUser(connect());
        $this->connexion = new ViewConnexion();
        $this->setHeader(new ViewHeader("<a href='#' data-popup-target='loginPopupOverlay'>Connexion</a>"));
        $this->setFooter(new ViewFooter());
    }

    //GETTER ET SETTER
    public function getUser(): ?ManagerUser { 
        return $this->user; }
        //++++++++++++++++++++SI CA NE MARCHE PLUS REMETTRE ?USER PLACE DE MANAGERUSER
    public function setUser(?ManagerUser $user): ControllerConnexion { 
        $this->user = $user; return $this; }

    public function getConnexion(): ?ViewConnexion { 
        return $this->connexion; 
    }
    public function setConnexion(?ViewConnexion $Nconnexion): ControllerConnexion { 
        $this->connexion = $Nconnexion; 
        return $this; 
    }

    //METHOD
    public function logInUser(){
        //Vérifier la réception du formulaire
        if(isset($_POST['submit'])){
            //Vérifie que les champs ne sont pas vides
            if(isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['password']) && !empty($_POST['password'])){
                //Vérifie que l'email est au bon format
                if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                    //Nettoyage des données
                    $email = sanitizeGuigui($_POST['email']);
                    $password = sanitizeGuigui($_POST['password']);

                    //J'enregistre les données dans le Modele User
                    $this->getUser()->setEmail($email)->setPassword($password);

                    //Je récupère les données utilisateur inscrit en BDD selon l'email entré
                    $data = $this->getUser()->readUserByMail();

                    //Vérifie que j'ai un utilisateur
                    if(!empty($data)){
                        //Vérifie la correspondance des mots de passe
                        if(password_verify($password,$data[0]['password_utilisateur'])){
                            //J'enregistre les infos en $_SESSION
                            $_SESSION['id_utilisateur'] = $data[0]['id_utilisateur'];
                            $_SESSION['pseudo_utilisateur'] = $data[0]['pseudo_utilisateur'];
                            $_SESSION['email_utilisateur'] = $data[0]['email_utilisateur'];
                            $_SESSION['id_role'] = $data[0]['id_role'];

                            //je redirige selon le role user ou admin de ma bdd
                            if (isset($_SESSION['id_role']) && $_SESSION['id_role'] === 2){
                                $_SESSION['success_message'] = "Connexion réussie!";
                                header('Location:controller_admin.php');
                                exit;
                            } else {
                                //Rediriger vers la page de compte
                                $_SESSION['success_message'] = "Connexion réussie!";
                                header('Location:controller_compte.php');
                                exit;
                            }

                        }else{
                            $this->connexion->setMessage("Login ou Mot de passe incorrect !");
                        $this->connexion->setIsPopupOpen(true);
                            
                        }

                    }else{
                        $this->connexion->setMessage("Aucun compte trouvé. ");
                        $this->connexion->setIsPopupOpen(true);
                    }
                }else{
                    $this->connexion->setMessage("L'email n'est pas au bon format !");
                        $this->connexion->setIsPopupOpen(true);
                }

            }else{
                $this->connexion->setMessage("Veuillez remplir tous les champs !");
                        $this->connexion->setIsPopupOpen(true);
            }
            $this->connexion->setIsPopupOpen(true);
        }
    }

    public function renderViews():void{
        ob_start();
          // Traite le formulaire d'inscription s'il est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->logInUser();
        }

        //Je vérifie si quelqu'un est connecté
        if(isset($_SESSION['id_utilisateur']) && !empty($_SESSION['id_utilisateur'])){
            //Je redirige vers l'accueil
            header('Location: Controller_accueil.php');
            exit;
        }

        //Je lance le Log In
        // $this->logInUser();//////////////////////////////////////////ATTENTION A REMETTRE SI BUG

        //Je lance le rendu du header
        // echo $this->renderHeader();

        // //Je lance le rendu de la connexion
        // echo $this->getConnexion()->render();
        // // Je lance le rendu du footer   
        // echo $this->getFooter()->render();
        echo $this->connexion->render();

    }
}

//Création du controller
$connexion = new ControllerConnexion();
//lancement du rendu
$connexion->renderViews();


?>