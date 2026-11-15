<?php

namespace App\Controller;

class NoterSourcerController extends AbstractController
{
    public function noterSourcer(): void
    {
        $this->render('noter_sourcer', 'Noter et Sourcer');
    }
}