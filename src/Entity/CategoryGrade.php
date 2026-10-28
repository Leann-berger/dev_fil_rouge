<?php

namespace App\Entity;

class CategoryGrade
{
    private ?int $id = null;
    private int $nameCategoryGrade;

    //construct

    public function __construct(
        int $nameCategoryGrade
    ){
        $this->nameCategoryGrade = $nameCategoryGrade;
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

    
    
    public function getNameCategoryGrade(): string
    {
        return $this->nameCategoryGrade;
    }

    public function setNameCategoryGrade(string $nameCategoryGrade): void
    {
        $this->nameCategoryGrade = $nameCategoryGrade;
    }


    //function pour hydrater

    public static function hydrate(array $categoryGrade): CategoryGrade
    {
        //creation de l'objet user
        $newCategoryGrade = new CategoryGrade(
            $categoryGrade["nameCategoryGrade"]
        );

        //set des attribut restant
        $newCategoryGrade->setId($categoryGrade["id_categoryGrade"] ?? null);
        
        //retourne l'objet nameCategoryGrade
        return $newCategoryGrade;

    }


}