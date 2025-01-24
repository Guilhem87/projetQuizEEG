<?php

class ViewHeader {
    private ?string $nav;
    private ?string $message;

    public function __construct(?string $nav) {
        $this->nav = $nav;
        $this->message = "";
    }
//GETTER SETTER
    public function getMessage() {
        return $this->message;
    }

    public function setMessage(?string $newMessage): ViewHeader {
        $this->message = $newMessage;
        return $this;
    }

    public function getNav() {
        return $this->nav;
    }

    public function setNav(?string $newNav): ViewHeader {
        $this->nav = $newNav;
        return $this;
    }
// methodes
    public function render(): string {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Popup Inscription et Connexion</title>
            <link rel="stylesheet" href="./src/style/style.css">
        </head>
        <body>
        <header>
            <a href="controller_accueil.php"><img src="pieuvre.svg" alt=""></a>
            <h1>QUIZ NUM'</h1><br><br>
            <nav>
            <a href="controller_accueil.php">Accueil</a><br>
            <?php echo $this->getNav(); ?><br><br>
            <!-- <a href="#" data-popup-target="loginPopupOverlay">Connexion</a> | 
            <a href="#" data-popup-target="registerPopupOverlay">Inscription</a> -->
            
            </nav>

                <p class="error-message" id="headerErrorMessage">
                    <?php echo $this->getMessage(); ?>
                </p><br>

            
        </header>
        
        <?php
        return ob_get_clean();
    }
}
