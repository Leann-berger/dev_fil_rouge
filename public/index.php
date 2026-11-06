<?php

include '../vendor/autoload.php';

session_start();


//récupération de l'URL (composante)
$url = parse_url($_SERVER["REQUEST_URI"]);

//extraction du path
$path = isset($url["path"]) ? $url["path"] : "/";


//importer
use App\Controller\HomeController;
use App\Controller\NoterSourcerController;
use App\Controller\UserController;



//instancier les controllers
$homeController = new HomeController();
$noterSourcerController = new NoterSourcerController();
$userController = new UserController();


//test des valeurs du path
switch ($path) {
    case '/':
        $homeController->home();
        break;
    case '/noterSourcer' :
        $noterSourcerController->noterSourcer();
        break;
    case '/login':
        $userController->login();
        break;
    case '/register':
        $userController->register();
        break;
    default:
        echo "Erreur 404";
        break;
}
