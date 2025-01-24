<?php


class User{

    //Attributs
    private ?int $id;
    private ?string $pseudo;
    private ?string $email;
    private ?string $password;

    private ?PDO $bdd;
    // private ?string $role = null; //role peut etre user admin ou null
    // // private ?int $roleId = null; // Stocke l'ID du rôle
    // // private ?string $roleName = null; // Stocke le nom du rôle pour un accès pratique

    
    //Constructeur

    public function __construct(?PDO $bdd){
        $this->bdd = connect();
    }


    //Getters
    public function getId(): int | null{
        return $this->id;
    }

    public function getPseudo() :string|null {
        return $this->pseudo;
    }

    public function getEmail() : string|null {
        return $this->email;
    }

    public function getPassword() :string |null{
        return $this->password;
    }
    public function getBdd():?PDO{
        return $this->bdd;
    }


    //Setters
    public function setId(?int $newId) :? User {
        $this->id = $newId;
        return $this;
    }

    public function setPseudo(?string $newPseudo) :? User {
        $this->pseudo = $newPseudo;
        return $this;
    }

    public function setEmail(?string $newEmail) :? User {
        $this->email = $newEmail;
        return $this;
    }

    public function setPassword(?string $newPassword) :? User {
        $this->password = $newPassword;
        return $this;
    }
    public function setBdd(?PDO $newBdd):?User{
        $this->bdd = $newBdd;
        return $this;
    }

    //Méthodes
// // METHODE ASSOCIER ROLE ET ID ROLE
// public function isAdmin(): bool {
//     return $this->roleName === 'admin';
// }

// public function isUser(): bool {
//     return $this->roleName === 'user';
// }

    //Méthodes qui hash le password avec Bcrypt	
    public function hashPassword() :void {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    //Méthode qui vérifie le mot de passe
    public function verifyPassword(string $plainPassword) :bool {
        return password_verify($plainPassword, $this->password);
    }

    //Méthode qui retourne le pseudo et email de l'objet User
    public function __tostring() :string {
        return $this->pseudo . ' ' . $this->email; 
    }

    //méthode qui hydrate en objet User
    public function hydrate(array $data) :self {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    //Méthode qui deshydrate l'objet User en tableau
    public function toArray() :array {
        $user = [];
        foreach ($this as $key => $value) {
            $method = 'get' . ucfirst($key);
            if (method_exists($this, $method)) {
                $user[$key] = $this->$method();
            }
        }
        return $user;         
    }
}
