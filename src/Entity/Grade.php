<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\CategoryGrade;
use App\Entity\Brand;
use App\Entity\Source;


class Grade
{
    private ?int $id = null;
    private int $valueGrade;
    private User $user;
    private CategoryGrade $categoryGrade;
    private Brand $brand;
    private Source $source;

    //construct

    public function __construct(
        int $valueGrade,
        User $user,
        CategoryGrade $categoryGrade,
        Brand $brand,
        Source $source
    ){
        $this->valueGrade = $valueGrade;
        $this->user = $user;
        $this->categoryGrade = $categoryGrade;
        $this->brand = $brand;
        $this->source = $source;
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


    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }


    public function getCategoryGrade(): CategoryGrade
    {
        return $this->categoryGrade;
    }

    public function setCategoryGrade(CategoryGrade $categoryGrade): void
    {
        $this->categoryGrade = $categoryGrade;
    }


    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }


    public function getSource(): Source
    {
        return $this->source;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }

    


    //function pour hydrater

    public static function hydrate(array $grade, User $user, CategoryGrade $categoryGrade, Brand $brand, Source $source): Grade
    {
        //creation de l'objet user
        $newGrade = new Grade(
            $grade["valueGrade"],
            $user,
            $categoryGrade,
            $brand,
            $source
        );

        //set des attribut restant
        $newGrade->setId($grade["id_grade"] ?? null);
        
        //retourne l'objet grade
        return $newGrade;

    }


}