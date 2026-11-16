<?php

namespace App\Controller;

use App\Service\BrandService;

class HomeController extends AbstractController
{
    private BrandService $brandService;

    public function __construct() 
    { 
        $this->brandService = new BrandService(); 
    }

    public function home(): void
    {
        $data = ["brands" => $this->brandService->getAllBrand(), "flash" => $_SESSION["flash"] ?? null];
        unset($_SESSION["flash"]);
        $this->render("home", "Accueil", $data);
    }
}