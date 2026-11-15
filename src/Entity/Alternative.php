<?php

namespace App\Entity;

class Alternative
{
    private Brand $brand;
    private Brand $alternative;

    //construct
    public function __construct(
        Brand $brand,
        Brand $alternative
    ){
        $this->brand = $brand;
        $this->alternative = $alternative;
    }

    //getter et setter

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }


    public function getAlternative(): Brand
    {
        return $this->alternative;
    }

    public function setAlternative(Brand $alternative): void
    {
        $this->alternative = $alternative;
    }


    //function pour hydrater

    public static function hydrate(Brand $brand, Brand $alternative): Alternative
    {
        //creation de l'objet alternative
        $newAlternative = new Alternative(
            $brand,
            $alternative
        );
        
        //retourne l'objet alternative
        return $newAlternative;

    }
}