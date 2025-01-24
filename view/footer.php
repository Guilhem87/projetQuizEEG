
<?php

class ViewFooter{
    private ?string $message;

    public function __construct()
    {
        $this->message = "";
    }

    public function setMessage(?string $newMessage):ViewFooter {
        $this->message = $newMessage;
        return $this;
    }

    public function getMessage(): ?string {
        return $this->message;
    }


    public function render():string{
        ob_start();
?>


<footer>
        <p>©_Projet crée par Evan,  Emilie & Guilhem</p>
        <nav>
            <ul> 
                <li>Nous contacter</li>
                <li>Qui sommes  nous ?</li>
                
            </ul>
        </nav><br><br>
        <p class="error-message">
    <?php
    if (isset($_SESSION['message'])) {
        echo htmlspecialchars($_SESSION['message']);
        unset($_SESSION['message']); // Supprime le message après affichage
    }
    ?>
</p>

    </footer>
    <script src="./src/script/script.js"></script>
</body>
</html>


<?php
        return ob_get_clean();
    }
}
?>