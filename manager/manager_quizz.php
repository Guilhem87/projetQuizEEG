<?php
class ManagerQuizz extends Quizz {

        private PDO $bdd;
    
        public function __construct(PDO $bdd) {
            $this->bdd = $bdd;
        }

        public function getBdd(): PDO {
            return $this->bdd;
        }


//METHODES

// questions au hasard dans la base de donnée.
    public function quizzRandomQuestions(?int $idTitreQuizz, ?int $limit = 10): array|string{
         // Req récupérer les questions et leurs réponses en une seule fois
        $req = $this->getBdd()->prepare('
            SELECT q.id_question, q.text_question, r.id_reponse, r.text_reponse, r.valide
            FROM Question q
            LEFT JOIN Reponse r ON r.id_question = q.id_question
            WHERE q.id_quizz = :id_quizz
            ORDER BY RAND()
            LIMIT :limit');
         // Vérification que id_quizz et limit sont bien définis
        if ($idTitreQuizz === null || $limit === null) {
            throw new Exception("Les paramètres id_quizz et limit sont obligatoires.");
        }

        $req->bindValue(':id_quizz', $idTitreQuizz, PDO::PARAM_INT);
        $req->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $req->execute();
        //recup réponse bdd
        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        $questions = [];

        foreach ($data as $questionData) {
            $question = new Question($questionData['id_question'], $questionData['text_question'], connect());

            $req2 = $this->getBdd()->prepare('SELECT id_reponse, text_reponse FROM Reponse WHERE id_question = :id_question');
            $req2->execute([':id_question' => $questionData['id_question']]);
            $data2 = $req2->fetchAll(PDO::FETCH_ASSOC);

            if (count($data2) != 4) {
                throw new Exception("Chaque question doit posseder 4 réponses possibles.");
            }
            foreach ($data2 as $answerData) {
                $valide = isset($answerData['valide']) ? (bool)$answerData['valide'] : false;
                $reponse = new Reponse($answerData['id_reponse'], $answerData['text_reponse'], $valide);
                $question->setReponse($reponse);
            }
            $questions[] = $question;
             // STOP BOUCLE SI la limite est atteinte
        if (count($questions) >= $limit) {
            break;
        }
        }
        return $questions;
    }




    public function getTitreQuestion (int $idQuizz):string|array{
        try {
        $req = $this->getBdd()->prepare('SELECT id_quizz, titre_quizz, description_quizz, id_categorie FROM Quizz WHERE id_quizz = ? LIMIT 1');

        //bind param
        // $idQuizz = $this->getTitre();
        // $idQuizz = $idQuizz;
        $req->bindParam(1,$idQuizz,PDO::PARAM_STR);

        //exec requete
        $req->execute();

        //recup données
        $data = $req->fetchAll();
        if ($data && isset($data[0]['titre_quizz'])) {
            return $data[0]['titre_quizz']; // Retourne du tableau asso avec comme valeur => titre_quizz la valeur 0 donc la premiere.
        }

        throw new Exception("Titre introuvable pour le quiz ID : $idQuizz");
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

//-------------------------TEST+++++++++++++++++++++++++++++++++++++++++++
public function submitQuizz(): array {
    $result = [
        'correctAnswers' => [], // Initialisation pour les bonnes réponses
        'message' => '',        // Message de retour
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $score = 0;
        $totalQuestions = 0;

        foreach ($_POST as $key => $userAnswers) {
            if (strpos($key, 'question') !== false) {
                $idQuestion = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);

                // Récupérer les bonnes réponses
                $req = $this->getBdd()->prepare("SELECT id_reponse FROM Reponse WHERE id_question = :id_question AND valide = 1");
                $req->execute(['id_question' => $idQuestion]);
                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                // Extraire les ID des bonnes réponses
                $correctAnswers = array_column($data, 'id_reponse');
                $result['correctAnswers'] = array_merge($result['correctAnswers'], $correctAnswers); // Ajout au tableau global

                // Vérifier les réponses de l'utilisateur
                $userAnswers = (array) $userAnswers;
                if (empty(array_diff($correctAnswers, $userAnswers)) && empty(array_diff($userAnswers, $correctAnswers))) {
                    $score++;
                }

                $totalQuestions++;
            }
        }

        // Déterminer le message de retour
        if ($score == $totalQuestions) {
            $result['message'] = "Bravo, vous êtes un as !";
        } elseif ($score > 0) {
            $result['message'] = "Je suis impressionné !";
        } else {
            $result['message'] = "Il est temps de jouer à Question pour un champion !";
        }
    }

    return $result;
}




}