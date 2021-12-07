<?php

namespace App\Controller;

use App\Model\Movies;
use Symfony\Component\HttpFoundation\Response;
// un use est nécessaire pour les @route
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
            'moviesList' => $moviesList
        ]);
    }

    /** 
     * @Route("/movie/{id}", name="main_movie_show", requirements={"id"="\d+"})
     */
    public function movieShow($id)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesModel = new Movies;
        $this_movie_info = $moviesModel->getMovieById($id);

        if($this_movie_info === null) {
            throw $this->createNotFoundException('Film ou série non trouvé.');
        }
        return $this->render('main/movieShow.html.twig', [
            'this_movie_info' => $this_movie_info
        ]);
    }


    /** 
     * @Route("/movies/list", name="main_movie_list")
     */
    public function list()
    {
        // on rend un template twig à partir du dossier templates/
        $moviesModel = new Movies;
        $moviesList = $moviesModel->getAllMovies();
        return $this->render('main/movieList.html.twig', [
            'moviesList' => $moviesList
        ]);
    }

    

    /** 
     * 
     * theme switcher
     * 
     * @Route("/theme/toggle", name="main_theme_switcher")
     */
    public function themeSwitcher(SessionInterface $session)
    {
        // notre but est de stocker en session utilisateur le theme choisi
        
        // on récupère le theme de la session
        $theme = $session->get('theme', 'netflix');

        // on inverse le theme
        if($theme === 'netflix' ) {
            $session->set('theme', 'allocine');
        } else{
            $session->set('theme', 'netflix');
        }

        // on redirige vers la home
        return $this->redirectToRoute('main_home');

        // puis dans le template base.html.twig on conditionnera le CSS de la nav selon le theme choisi
    }
}