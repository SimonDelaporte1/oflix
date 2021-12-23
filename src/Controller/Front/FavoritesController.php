<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Model\Movies;
use App\Repository\MovieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoritesController extends AbstractController
{
    /** 
     * @Route("/favorites", name="favorites_list")
     */
    public function list(MovieRepository $MovieRepository)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesList = $MovieRepository->findAll();
        return $this->render('front/favorites/list.html.twig', [
            'moviesList' => $moviesList
        ]);
    }

    /**
     * Favorite gestion
     * 
     * @Route("/favorites/gestion/{id}", name="favorite_gestion", requirements={"id"="\d+"})
     */
    public function favorite($id, Movie $movie, SessionInterface $session, MovieRepository $movieRepository)
    {
        // 1. On récupère les favoris en session
        $myFavorites = $session->get('myFavorites', []);

        // 2. On met à jour le tableau récupéré

        // Si le film est déjà dans les favoris
        if (array_key_exists($id, $myFavorites)) {
            // On le retire
            // $key = array_search($id, $myFavorites);
            unset($myFavorites[$id]);
            $this->addFlash('success', $movie->getTitle().' retiré(e) des favoris');
        } else {
            // Sinon on l'ajoute
            $myFavorites[$id] = $movie;
            $this->addFlash('success', $movie->getTitle().' ajouté(e) aux favoris');
        }

        // 3. On écrase les favoris en session
        $session->set('myFavorites', $myFavorites);

        // On redirige vers la home
        return $this->redirectToRoute('favorites_list');
    }

    /**
     * Favorite gestion, vider la liste
     * 
     * @Route("/favorites/gestion/purge", name="favorites_purge")
     */
    public function purgeFavorites(SessionInterface $session)
    {
        // On vide l'attribut de session concerné
        $session->remove('myFavorites');

        $this->addFlash('success', 'Favoris supprimés');

        // On redirige vers la liste
        return $this->redirectToRoute('favorites_list');
    }
}
