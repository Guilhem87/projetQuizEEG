<?php

class Quizz{
//ATTRIBUTS
    private ?int $id;
    private ?string $titre;
    private ?array $questions;

    // private ?string $text;

    // private ?PDO $bdd;

    public function __construct( ?string $titre = null){ //?PDO $bdd
        $this->id = 0;
        $this->titre = $titre ??'';
        $this->questions = [];
        $this->bdd = connect();
        // $this->text = $text;
    }

    //GETTER SETTER

    public function getQuestion():array{
        return $this->questions;
    }

    public function setQuestion(Question $questions):void{
        $this->questions[] = $questions;
    }
    // public function getBdd():?PDO{
    //     return $this->bdd;
    // }
    // public function setBdd(?PDO $newBdd):?Quizz{
    //     $this->bdd = $newBdd;
    //     return $this;
    // }


    // public function getText(): ?string {
    //     return $this->text;
    // }
    // public function settext(?string $text): Quizz {
    //     $this->text = $text;
    //     return $this;
    // }

    public function getId():int{
        return $this->id;
    }
    public function setId(int $id):Quizz{
        $this->id = $id;
        return $this;
    }

    public function getTitre(): ?string {
        return $this->titre;
    }
    public function setTitre(string $titre):void{
        $this->titre = $titre;
    }

}