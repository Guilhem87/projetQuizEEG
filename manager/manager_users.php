<?php

class ManagerUser extends User {
    public function readUsers():array | string{
        try{
            //Requete préparé
            $req = $this->getBdd()->prepare('SELECT id_utilisateur, pseudo_utilisateur, email_utilisateur, password_utilisateur FROM Utilisateur');

            //Exécution de la requête
            $req->execute();

            //Récupérer la réponse de la bdd : je reçois un tableau contenant des tableaux d'utilisateurs
            $data = $req->fetchAll(PDO::FETCH_ASSOC);

            return $data;

        }catch(EXCEPTION $error){
            return $error->getMessage();
        }
    }

    public function readUserByMail():array|string{
        try{
            //Préparation de ma requête SELECT
            $req = $this->getBdd()->prepare('SELECT id_utilisateur, pseudo_utilisateur, email_utilisateur, password_utilisateur, id_role FROM Utilisateur WHERE email_utilisateur = ? LIMIT 1');

            //Binding de Param :
            $email = $this->getEmail();
            $req->bindParam(1,$email,PDO::PARAM_STR);

            //Exécuter la requête
            $req->execute();

            //Récupération de la réponse de la BDD
            $data = $req->fetchAll();
            var_dump($data);
            return $data;

        }catch(EXCEPTION $error){
            return $error->getMessage();
        }
    }

    public function createUser():string{
        
        try{
            //Prepare notre requête d'INSERT
            $req = $this->getBdd()->prepare('INSERT INTO Utilisateur (pseudo_utilisateur, email_utilisateur, password_utilisateur) VALUES (?,?,?)');

            //Binding de Param :
            // $role = $this->getRole();
            $pseudo = $this->getPseudo();
            $password = $this->getPassword();
            $email = $this->getEmail();
            
            $req->bindValue(1,$pseudo,PDO::PARAM_STR);
            $req->bindValue(2,$email,PDO::PARAM_STR);
            $req->bindValue(3,$password,PDO::PARAM_STR);
            // $req->bindParam(5,$role,PDO::PARAM_STR);

            //Exécution de la requête
            $req->execute();

            return "$pseudo avec l'adresse $email a été enregistré avec succès !";
        }catch(Exception $error){
            return $error->getMessage();
        }
    }

    function updateUser() {
        try{
            $req = $this->getBdd()->prepare('UPDATE Utilisateur SET id_utilisateur = ?, pseudo_utilisateur = ?, email_utilisateur = ?, password_utilisateur = ? WHERE id_utilisateur = ?');
    
            $pseudo = $this->getPseudo();
            $email = $this->getEmail();
            $password = $this->getPassword();
            $id = $this->getId();
            //biding parametres
            $req->bindParam(1, $id, PDO::PARAM_INT);
            $req->bindParam(2,$pseudo,PDO::PARAM_STR);
            $req->bindParam(3,$email,PDO::PARAM_STR);
            $req->bindParam(4,$password,PDO::PARAM_STR);
            $req->bindParam(5, $id, PDO::PARAM_INT);
    
            if ($req->execute()) {
                return "Mise à jour réussie.";
            } else {
                $errorInfo = $req->errorInfo();
                return "Erreur SQL : " . $errorInfo[2]; // Affiche l'erreur SQL
            }
        }catch(EXCEPTION $error)
            {return $error->getMessage();}
        }
}
?>