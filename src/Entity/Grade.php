<?php

namespace App\Entity;


class Grade
{
    private ?int $id = null;
    private int $valueGrade;

    //construct

    public function __construct(
        int $valueGrade
    ){
        $this->valueGrade = $valueGrade;
    }

    //getter et setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    
    
    public function getValueGrade(): int
    {
        return $this->valueGrade;
    }

    public function setValueGrade(int $valueGrade): void
    {
        $this->valueGrade = $valueGrade;
    }


    //function pour hydrater

    public static function hydrate(array $grade): Grade
    {
        //creation de l'objet user
        $newGrade = new Grade(
            $grade["valueGrade"]
        );

        //set des attribut restant
        $newGrade->setId($grade["id_grade"] ?? null);
        
        //retourne l'objet grade
        return $newGrade;

    }


}