<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\HttpFoundation\Response;
// un use est nécessaire pour les @route
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



Class MainController extends AbstractController
{
    /** 
     * @Route("/", name="main_home")
     */
    public function home()
    {
        // on rend un template twig à partir du dossier templates/
        $moviesModel = new Movies;
        $moviesList = $moviesModel->getAllMovies();
        return $this->render('main/home.html.twig', [
            'moviesList' => $moviesList,
            'BASE' => $_SERVER['BASE']
        ]);
    }

    /** 
     * @Route("/movie/{id}", name="main_movie_show")
     */
    public function movieShow($id)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesModel = new Movies;
        $moviesList = $moviesModel->getAllMovies();
        $this_movie_info = $moviesList[$id];
        return $this->render('main/movieShow.html.twig', [
            'this_movie_info' => $this_movie_info,
            'BASE' => $_SERVER['BASE']
        ]);
    }

    /** 
     * @Route("/favorites.html", name="main_movie_favoris")
     */
    public function movieFavoris()
    {
        // on rend un template twig à partir du dossier templates/
        $moviesModel = new Movies;
        $moviesList = $moviesModel->getAllMovies();
        return $this->render('main/movieFavoris.html.twig', [
            'moviesList' => $moviesList,
            'BASE' => $_SERVER['BASE']
        ]);
    }
}