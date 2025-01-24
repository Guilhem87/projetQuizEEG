<?php
include './controller.php';
include './view/view_quizz.php';
include './App/Model/Quizz.php';
include './manager/manager_quizz.php';
include './App/Utils/Bdd.php';
include './App/Model/Question.php';
include './App/Model/Reponse.php';



class ControllerQuizz extends Controller {

    private ?ViewQuizz $viewQuizz;

    private ?ManagerQuizz $managerQuizz;


    public function __construct(){
        $quizz = new Quizz('');
        $this->viewQuizz = new ViewQuizz($quizz);
        $this->managerQuizz = new ManagerQuizz(connect());
        $this->setHeader(new ViewHeader(""));
        $this->setFooter(new ViewFooter());

    }

    public function getViewQuizz(): ViewQuizz {
        return $this->viewQuizz;
    }
    public function setViewQuizz(ViewQuizz $newViewQuizz): ControllerQuizz {
        $this->viewQuizz = $newViewQuizz;
        return $this;
    }

//METHODESSSSSSSS


public function handleSubmit(): ?array {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return $this->managerQuizz->submitQuizz();
    }
    return null; // Retourne null si aucune soumission n'a été effectuée
}



public function render() {
    // Appelle la méthode handleSubmit pour obtenir les résultats après la soumission
    $result = $this->handleSubmit(); // Récupère le résultat du formulaire
    
    // Passage de $result à la vue
    $this->getViewQuizz()->setResult($result); // Assurez-vous que vous avez une méthode setResult dans votre vue
    include 'view_quizz.php'; // Inclut la vue et passe la variable
}







    
    public function renderQuizz(int $idQuizz, $limit): void {
        $result = $this->handleSubmit();
        //recup le titre du quizz
        $titre = $this->managerQuizz->getTitreQuestion($idQuizz);
        if (!$titre) {
            echo "<p>Quiz introuvable.</p>";
            return;
        } // je fais le rendu du titre recup ds bbd nom_quizz
        $this->getViewQuizz()->setTitre($titre); 

        //recup les questuions du quizz
        $questions = $this->managerQuizz->quizzRandomQuestions($idQuizz, $limit);
          // Vérifier si des questions ont été trouvées
    if (empty($questions)) {
        echo "<p>Aucune question trouvée pour ce quiz.</p>";
        return;
    } //mettre les questions recup ds la vue 
    $this->viewQuizz->getQuizz()->setQuestion($questions[0]);

        //rendu de mes views 
        echo $this->getHeader()->render();
        echo $this->viewQuizz->render();
        echo $this->getFooter()->render();
    }

}



