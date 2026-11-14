<?php

namespace App\Controller;

class NoterSourcerController extends AbstractController
{
    public function noterSourcer(): void
    {
        $this->render('noterSourcer', 'Noter et Sourcer');
    }
}