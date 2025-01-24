<?php

class ViewQuizz {
    private Quizz $quizz;
    private ?string $message;

    private ?array $result = null;
    // private ?int $monScore;
    // private ?int $monMeilleurScore;
    // private ?int $meilleurScoreEver;
    private ?string $titre;

    public function __construct(?Quizz $quizz) {
        $this->message = '';
        $this->quizz = $quizz;
        $this->titre = '';
        $this->result = null;
        // $this->monScore = null;
        // $this->monMeilleurScore = null;
        // $this->meilleurScoreEver = null;
    }

    public function setResult(?array $result): void {
        $this->result = $result;
    }

    public function getResult(): ?array {
        return $this->result;
    }



    public function getMessage(): ?string {
        return $this->message;
    }

    public function setMessage(?string $message): ViewQuizz {
        $this->message = $message;
        return $this;
    }

    
    public function setQuizz(?Quizz $quizz): ViewQuizz {
        $this->quizz = $quizz;
        return $this;
    }
    public function getQuizz(): Quizz {
        return $this->quizz;
    }
    public function getTitre(){
        return $this->titre;
    }
    public function setTitre(?string $newTitre): ViewQuizz {
        $this->titre = $newTitre;
        return $this;
    }







    // public function getMonscore(): ?int {
    //     return $this->monScore;
    // }
    // public function getMonMeilleurScore(): ?int {
    //     return $this->monMeilleurScore;
    // }
    // public function getMeilleurScoreEver(): ?int {
    //     return $this->meilleurScoreEver;
    // }



//METHODES
    public function render():void{
        // ob_start();
        
    ?>
<main>
    <h1><?php echo "Quizz sur {$this->getTitre()}"; ?></h1> <!-- Affiche le titre -->
    <form method="post" action="">
        <div class="quizz">
            <?php foreach ($this->quizz->getQuestion() as $question): ?>
                <?php if ($question instanceof Question): ?>
                    <h3><?= htmlspecialchars($question->getText()); ?></h3>
                    <?php foreach ($question->getReponse() as $reponse): ?>
                        <label>
                            <input type="checkbox" name="question<?= $question->getId(); ?>[]" value="<?= $reponse->getId(); ?>">
                            <?= htmlspecialchars($reponse->getText()); ?>
                        </label><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Objet non valide pour une question.</p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <br><br>
        <button class="boutonquizz" type="submit">Envoyer</button>
    </form>


        <!-- AFFICHAGE RESULTAT-->
        <?php if ($this->result): ?>
            <div class="feedback">
                <p><strong><?= htmlspecialchars($this->result['message']); ?></strong></p>
                <?php if (!empty($this->result['correctAnswers'])): ?>
                    <p>Les bonnes réponses étaient :</p>
                    <ul>
                        <?php foreach ($this->result['correctAnswers'] as $correctAnswerId): ?>
                            <li>Réponse ID : <?= htmlspecialchars($correctAnswerId); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>




    <?php 
    // ob_end_flush();
    }
}