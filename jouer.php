<?php
include './controller_quizz.php';

// Vérifie si un ID de quiz est fourni dans l'URL
$idQuizz = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si un quiz est sélectionné, afficher le quiz
if ($idQuizz > 0) {
    $viewQuizz = new ControllerQuizz();
    $viewQuizz->handleSubmit();
    // Selon l'ID du quiz, on affiche le quiz avec le bon nombre de questions
    switch ($idQuizz) {
        case 1:
            $viewQuizz->renderQuizz($idQuizz, 10); // Quiz 1, 10 questions
            break;
        case 2:
            $viewQuizz->renderQuizz($idQuizz, 15); // Quiz 2, 15 questions
            break;
        default:
            echo "<p>Erreur : Quiz non trouvé.</p>";
            break;
    }
} else {
    echo "<p>Erreur : Aucun quiz sélectionné.</p>";
}
?>
