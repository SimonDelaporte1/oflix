<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
// un use est nécessaire pour les @route
use Symfony\Component\Routing\Annotation\Route;



Class MainController
{
    /** 
     * @Route("/", name="main_home")
     */
    public function home()
    {
        // affiche quelque chose
        return new Response("Bienvenue sur O'flix");
    }

    /** 
     * @Route("/movie/{id}", name="main_movie_show")
     */
    public function movieShow($id)
    {
        // affiche quelque chose
        return new Response("Page du film/série dont l'id est : " . $id);
    }
}