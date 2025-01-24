<?php
/////////////////////////////////////
//Création des Fonctions Utilitaires
/////////////////////////////////////

/*sanitizeYoyo() : enlève les balises HTML, PHP, les espaces et les caractères d'échappement
* Param : $data -> string
* Return : string
*/
function sanitizeGuigui($data){
    return htmlentities(strip_tags(stripslashes(trim($data))));
}

/**
 * connect() : crée un objet de connexion à la BDD
 * Param : void
 * Return : object PDO
 */
// function connect(){
//     $bdd = new PDO('mysql:host=localhost;dbname=ege','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

//     return $bdd;
// }

//CONNECT AMELIORER POUR GERE LES DECONNECTION

function connect() {
    static $bdd = null;

    if ($bdd === null) {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=ege', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
    return $bdd;
}

function seCo() {
    return isset($_SESSION['pseudo_utilisateur'], $_SESSION['id_utilisateur'], $_SESSION['email_utilisateur']) &&
    !empty($_SESSION['pseudo_utilisateur']) && !empty($_SESSION['id_utilisateur']) && !empty($_SESSION['email_utilisateur']);
};

?>
