<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
// un use est nécessaire pour les @route
use Symfony\Component\Routing\Annotation\Route;



Class MainController extends AbstractController
{
    /** 
     * @Route("/", name="main_home")
     */
    public function home()
    {
        // on rend un template twig à partir du dossier templates/
        return $this->render('main/home.html.twig');
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