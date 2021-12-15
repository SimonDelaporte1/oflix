<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
// un use est nécessaire pour les @route
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

Class MainController extends AbstractController
{
    /** 
     * @Route("/", name="main_home")
     */
    public function home(MovieRepository $MovieRepository, GenreRepository $GenreRepository)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesList = $MovieRepository->findAll();
        $genreList = $GenreRepository->findAll();
        return $this->render('main/home.html.twig', [
            'moviesList' => $moviesList,
            'genreList' => $genreList
        ]);
    }

    /** 
     * @Route("/movie/{id}", name="main_movie_show", requirements={"id"="\d+"})
     */
    public function movieShow(MovieRepository $MovieRepository, $id)
    {
        // on rend un template twig à partir du dossier templates/
        $this_movie_info = $MovieRepository->find($id);

        if($this_movie_info === null) {
            throw $this->createNotFoundException('Film ou série non trouvé.');
        }

        // dd($this_movie_info);
        return $this->render('main/movieShow.html.twig', [
            'this_movie_info' => $this_movie_info
        ]);
    }


    /** 
     * @Route("/movies/list", name="main_movie_list")
     */
    public function list(MovieRepository $MovieRepository)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesList = $MovieRepository->findAllOrderedByTitleAscQb();
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