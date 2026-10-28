<?php

namespace App\Entity;

class CategoryBrand
{
    private ?int $id = null;
    private string $categoryBrand;

    //construct
    public function __construct(
        string $categoryBrand
    ){
        $this->categoryBrand = $categoryBrand;
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


    public function getCategoryBrand(): string
    {
        return $this->categoryBrand;
    }

    public function setCategoryBrand(string $categoryBrand): void
    {
        $this->categoryBrand = $categoryBrand;
    }


    //function pour hydrater

    public static function hydrate(array $categoryBrand): CategoryBrand
    {
        //creation de l'objet user
        $newCategoryBrand = new CategoryBrand(
            $categoryBrand["categoryBrand"]
        );

        //set des attribut restant
        $newCategoryBrand->setId($categoryBrand["id_categoryBrand"] ?? null);
        
        //retourne l'objet categoryBrand
        return $newCategoryBrand;

    }
}