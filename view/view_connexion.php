<?php
class ViewConnexion {
    private ?string $message;

    private bool $isPopupOpen;

    public function __construct() {
        $this->message = "";
        $this->isPopupOpen = false;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function setMessage(?string $message): ViewConnexion {
        $this->message = $message;
        return $this;
    }

    public function setIsPopupOpen(bool $isPopupOpen): ViewConnexion {
        $this->isPopupOpen = $isPopupOpen; 
        return $this;
    }

    public function isPopupOpen(): bool {
        return $this->isPopupOpen;
    }

    public function render() {
        ob_start();
?>
<div class="popup-overlay" id="loginPopupOverlay" 
        style="display: <?php echo $this->isPopupOpen ? 'block' : 'none'; ?>;" 
        aria-hidden="<?php echo $this->isPopupOpen ? 'false' : 'true'; ?>"> <!-- remettre echo devant this -->
    <div class="popup">
        <button class="close-btn" id="closeLoginPopup" aria-label="Fermer la fenêtre">X</button>
        <h2>Se connecter</h2>
        <form id="loginForm" action="controller_connexion.php" method="POST">
            <label for="username">Email | Pseudo :</label>
            <input type="text" name="email" id="username" placeholder="Ton email ou pseudo" required><br><br>
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="password" placeholder="Ton mot de passe" required><br><br>
            <button type="submit" name="submit">Se connecter</button><br><br>
        </form>
        <a href="#" data-target="registerPopupOverlay" class="switch-popup">Créer un compte</a>
        <!-- Affiche le message d'erreur si présent -->
        <?php if ($this->getMessage()): ?>
            <p class="error-message"><?= htmlspecialchars($this->getMessage()) ?></p>
        <?php endif; ?>
    </div>
</div>
<script src="./src/script/script.js"></script>            
<?php
        return ob_get_clean();
    }
}
?>
