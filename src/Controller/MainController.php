<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

Class MainController
{
    public function home()
    {
        // affiche quelque chose
        return new Response("Bienvenue sur O'flix");
    }
}