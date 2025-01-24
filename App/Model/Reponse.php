<?php

class Reponse {

        private ?int $id;
        private ?string $text;
        private ?bool $valide;

        // private ?PDO $bdd;
    
        public function __construct(int $id, string $text, bool $valide) {//, PDO $bdd
            $this->id = $id;
            $this->text = $text;
            $this->valide = $valide;
            $this->bdd = connect();
        }
    
        public function estValide(): bool {
            return $this->valide;
        }
    
        public function getText(): string {
            return $this->text;
        }
    
        public function getId(): int {
            return $this->id;
        }

        public function setText(?string $newText):?Reponse {
            $this->text = $newText;
            return $this;
        }
        public function setId(int $id):?Reponse {
            $this->id = $id;
            return $this;
        }

        
    // public function getBdd():?PDO{
    //     return $this->bdd;
    // }
    // public function setBdd(?PDO $newBdd):?Reponse{
    //     $this->bdd = $newBdd;
    //     return $this;
    // }
        
    }
    
