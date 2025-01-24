<?php

class Question {
    private ?int $id;
    private ?string $text;
    private ?array $reponse;
    private ?PDO $bdd;

    public function __construct(?int $id, ?string $text, ?PDO $bdd){//
        $this->id = $id;
        $this->text = $text;
        $this->reponse = [];
        $this->bdd = connect();
    }

    public function getId(): ?int {
        return $this->id;
    }
    public function getText(): ?string {
        return $this->text;
    }
    public function getreponse(): ?array {
        return $this->reponse;
    }
    public function getBdd():?PDO{
        return $this->bdd;
    }
    public function setBdd(?PDO $newBdd):?Question{
        $this->bdd = $newBdd;
        return $this;
    }


    public function setId(?int $id): Question {
        $this->id = $id;
        return $this;
    }
    public function settext(?string $text): Question {
        $this->text = $text;
        return $this;
    }
    public function setReponse($reponse): Question {
        count($this->reponse) <= 4;
        $this->reponse[] = $reponse;
        return $this;
    }

    //methode


}