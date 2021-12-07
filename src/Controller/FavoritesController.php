<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoritesController extends AbstractController
{
    /** 
     * @Route("/favorites", name="favorites_list")
     */
    public function list()
    {
        // on rend un template twig à partir du dossier templates/
        $moviesModel = new Movies;
        $moviesList = $moviesModel->getAllMovies();
        return $this->render('favorites/list.html.twig', [
            'moviesList' => $moviesList
        ]);
    }
}
