
    <?php
    
class ViewAccueil{
    private ?string $listUsers;

    public function __construct()
    {
        $this->listUsers = "";
    }


    public function getListUsers(){
        return $this->listUsers;
    }
    public function setListUsers(?string $newListUsers):ViewAccueil{
        $this->listUsers = $newListUsers;
        return $this;
    }

    public function cardUser($user):?string{
        ob_start();
?>
        <li><?php echo "{$user['pseudo_utilisateur']} : {$user['email_utilisateur']}"?></li>
<?php
        return ob_get_clean();
    }

    public function render():string{
        ob_start();
?>
<main>
        <input type="search" name="Rechercher un joueur" id="Rechercher un joueur" placeholder="Rechercher un joueur">
    <h3>NOS THEMES</h3>

    <div class="cards">
        <card id="card1">
            <h4>Les logos du numérique</h4>
            <img src="./src/img/logo_apple.png" alt="logo de la marque Apple">
            <p>Trouvez de quel logo il s'agit</p>
            <a href="jouer.php?id=1"><input  type="button" value="Jouer le quizz"></a>
        </card>
        <card id="card2">
            <h4>Histoire du numérique</h4>
            <img src="./src/img/histoireDuNumerique.png" alt="Histoire du Numerique">
            <p>Apprends sur l'histoire du numérique</p>         
            <a href="jouer.php?id=2"><input  type="button" value="Jouer le quizz"></a>
        </card>
        <card id="card3">
            <h4>Les bases à connaitre !</h4>
            <img src="./src/img/groupLogo.png" alt="logo de la marque Apple">
            <p>Apprends les bases de dévellopement</p>
            <a href="jouer.php?id=3"><input type="button" value="Jouer le quizz"></a>
        </card>
    </div>

    </main>
<?php
        return ob_get_clean();
    }
}
?>