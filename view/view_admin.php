<?php

class ViewAdmin {
    //attributs
    private ?string $message;

    public function __construct() {
    $this->message = "";
}
//getter setter
public function getMessage() {
    return $this->message;
}
public function setMessage(?string $newMessage): ViewAdmin {
    $this->message = $newMessage;
    return $this;
}

//methode

public function render(): string {
    ob_start();

    ?>
<main>
<link rel="stylesheet" href="./src/style/style_admin.css">
    <h3>Section Administrateur </h3>

    <div class="cards">
        <a href="#"><div id="card1" class="biscotte">
            <h4>GESTION QUIZ & THEMES</h4>
        </div></a>

        <a href="#"><div id="card2">
            <h4>GESTION PROFIL</h4>
        </div></a>

        <a href="#"><div id="card3">
            <h4>GESTION COMMENTAIRES</h4>
        </div></a>

        <a href="#"><div id="card4">
            <h4>STATISTIQUE QUIZ</h4>
        </div></a>

        <a href="#"><div id="card5">
            <h4>STATISTIQUE JOUEUR</h4>
        </div></a>

    </div>
    <div class="cards2">
        <a href="#"><div id="card6">
            <h4>MESSAGE ADMIN</h4>
        </div></a>

        <a href="#"><div id="card7">
            <h4>STATISTIQUE THEMES</h4>
        </div></a>
    </div>


    </main>
    <?php

    return ob_get_clean();
}

}