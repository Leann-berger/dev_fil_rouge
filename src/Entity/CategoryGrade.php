<?php

namespace App\Entity;

class CategoryGrade
{
    private ?int $id = null;
    private string $nameCategoryGrade;

    //construct

    public function __construct(
        string $nameCategoryGrade
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
        //creation de l'objet nameCategoryGrade
        $newCategoryGrade = new CategoryGrade(
            $categoryGrade["name_grade_category"]
        );

        //set des attribut restant
        $newCategoryGrade->setId($categoryGrade["id_grade_category"] ?? null);
        
        //retourne l'objet nameCategoryGrade
        return $newCategoryGrade;

    }


}