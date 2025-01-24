<?php


class ViewCompte {
//ATTRIBUTS
    private ?string $pseudo;
    private ?string $email;
    private ?string $listUsers;

    private ?int $score;

    //CONSTRUCTEUR

    public function __construct() {
        $this->pseudo = "";
        $this->email = "";
        $this->score = 0;
        $this->listUsers ="";
    }

    //GETTER & SETTER

    public function getPseudo(): ?string {
        return $this->pseudo;
    }
    public function setPseudo(?string $pseudo): ViewCompte {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }
    public function setEmail(?string $email): ViewCompte {
        $this->email = $email;
        return $this;
    }

    public function getScore(): ?int {
        return $this->score;
    }
    public function setScore(?int $score): ViewCompte {
        $this->score = $score;
            return $this;
    }

    public function getListUsers(){
        return $this->listUsers;
    }
    public function setListUsers(?string $newListUsers):ViewCompte{
        $this->listUsers = $newListUsers;
        return $this;
    }

    //METHOD 

    public function render() {
        ob_start();
        ?>
        <main>
            <h1>Mon Compte Perso</h1>
            <h2><?php echo " Bienvenue {$this->getPseudo()}! Les résultats de vos derniers Quizz: {$this->getScore()}"; ?></h2>
            <section>
                <h1>Liste des Amis</h1>
                <ul>
                    <?php echo $this->getListUsers() ?>
                </ul>
            </section>
        </main>
        <?php
        return ob_get_clean();
    }
    public function nomUser($user):?string{
        ob_start();
?>
        <li><?php echo "{$user['pseudo_utilisateur']}"?></li>
<?php
        return ob_get_clean();
    }

}