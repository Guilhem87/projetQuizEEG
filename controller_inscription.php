<?php
include './controller.php';
include './App/Utils/Bdd.php';
include './App/Model/User.php';
include './manager/manager_users.php';
include './view/view_inscription.php';

class ControllerInscription extends Controller {
    private ?ManagerUser $user;
    private ?ViewInscription $inscription;


    public function __construct() {
        $this->user = new ManagerUser(connect());
        $this->inscription = new ViewInscription();
        
        $this->setHeader(new ViewHeader(""));
        $this->setFooter(new ViewFooter());
    }

    public function getUser(): ?ManagerUser { 
        return $this->user; 
    }
    public function setUser(?ManagerUser $user): ControllerInscription { 
        $this->user = $user; 
        return $this; 
    }

    public function getInscription(): ?ViewInscription { 
        return $this->inscription; 
    }
    public function setInscription(?ViewInscription $Ninscription): ControllerInscription { 
        $this->inscription = $Ninscription; 
        return $this; 
    }

    public function registerUser():void{
        //Vérifier que je reçois le formulaire d'incription
        if(isset($_POST['submit'])){
            //Vérifie que les données ne sont pas vides
            if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])
            && isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['password']) && !empty($_POST['password'])
            && isset($_POST['passwordVerify']) && !empty($_POST['passwordVerify'])){
                    //Vérifier que le mail est au bon format
                    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                            //Vérifie que les 2 mots de passe correspondent
                            if($_POST['password'] === $_POST['passwordVerify']){
                                    //Nettoyage des données
                                    $pseudo = sanitizeGuigui($_POST['pseudo']);
                                    $email = sanitizeGuigui($_POST['email']);
                                    $password = sanitizeGuigui($_POST['password']);
                                    //Hasher le mot de passe
                                    $password = password_hash($password, PASSWORD_BCRYPT);
                                    //Vérifier si l'utilisateur est déjà enregistré ou pas en BDD
                                    //Enregistrement des données dans l'objet ModelUser
                                    $this->getUser()->setPseudo($pseudo)->setEmail($email)->setPassword($password);
    
                                    $data = $this->getUser()->readUserByMail();
    
                                    //Vérifie si $data est vide, pour savoir si l'email est disponible à l'enregistrement
                                    if(empty($data)){
                                                
                                        //On commence à enregistrer le compte, car l'email est disponible et j'enregistre le message dans mon accueil
                                        $this->getHeader()->setMessage($this->getUser()->createUser());
                                        header('Location:Controller_accueil.php');
                                        $this->getHeader()->setMessage('Création de compte validé!');
                                        exit;
                                    }else{
                                        $this->inscription->setMessage("Cet email est déjà utilisé par un autre compte !");
                                        $this->inscription->setIsPopupOpen(true);
                                        
                                    }
    
                            }else{
                                $this->inscription->setMessage("Les mots de passe ne correspondent pas.");
                                $this->inscription->setIsPopupOpen(true);
                                // $_SESSION['message'] = $this->getHeader()->getMessage();
    
                            }
    
                    }else{
                        $this->inscription->setMessage("Votre email n'est pas au bon format !");
                        $this->inscription->setIsPopupOpen(true);;
                    }
    
            }else{
                $this->inscription->setMessage("Tous les champs doivent être remplis.");
                $this->inscription->setIsPopupOpen(true);;
            }
        }
    
    }

    public function renderViews(): void {
          // Traite le formulaire d'inscription s'il est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerUser();
        }
        // echo $this->renderHeader();
        // echo $this->getInscription()->render();
        // echo $this->getFooter()->render();
        echo $this->inscription->render();
    }
}

// Initialisation du contrôleur
$viewInscription = new ControllerInscription();
$viewInscription->renderViews();
