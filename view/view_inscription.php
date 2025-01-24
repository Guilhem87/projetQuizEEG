<?php
class ViewInscription{
    //YD:ATTRIBUT
    private ?string $message;
    private bool $isPopupOpen;

    //YD:CONSTRUCTEUR
    public function __construct(){
        $this->message = "";
        $this->isPopupOpen = false;
    }

    //GETTER ET SETTER
    public function getMessage(): ?string { 
        return $this->message; }
    public function setMessage(?string $message): ViewInscription {
        $this->message = $message;
        return $this;
    }

    public function setIsPopupOpen(bool $isPopupOpen): ViewInscription {
        $this->isPopupOpen = $isPopupOpen; 
        return $this;
    }

    public function isPopupOpen(): bool {
        return $this->isPopupOpen;
    }
    //METHOD
    public function render(){
        ob_start();
?>
<div class="popup-overlay" id="registerPopupOverlay" 
        style="display: <?php echo $this->isPopupOpen ? 'block' : 'none'; ?>;" 
        aria-hidden="<?php echo $this->isPopupOpen ? 'false' : 'true'; ?>">
        <div class="popup">
            <button class="close-btn" id="closeRegisterPopup">X</button>
            <h2>Inscription</h2>
            <form id="registerForm" action="controller_inscription.php" method="POST">
                <label for="email">Adresse Mail :</label>
                <input type="email" id="email" name="email" placeholder="Ton email" required><br><br>
                <label for="pseudo">Pseudo :</label><br>
                <input type="text" id="pseudo" name="pseudo" placeholder="Ton pseudo" required><br><br>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Ton mot de passe" required><br><br>
                <label for="passwordVerify">Vérifier le mot de passe :</label>
                <input type="password" id="passwordVerify" name="passwordVerify" placeholder="Confirme ton mot de passe" required><br><br>
                <button type="submit" name="submit">S'inscrire</button><br><br>
                <p class="error-message" id="registerErrorMessage">
                <?php echo htmlspecialchars($this->getMessage()); ?>
                </p>
            </form>
        </div>
    </div>
    <script src="./src/script/script.js"></script>

<?php
        return ob_get_clean();
    }
}
?>