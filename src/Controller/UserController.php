<?php

namespace App\Controller;

class UserController extends AbstractController
{
    public function login(): mixed
    {
        $this->render('login', 'Connexion');
    }
    
    public function register(): mixed
    {
        $this->render('register', 'Inscritpion');
    }
}