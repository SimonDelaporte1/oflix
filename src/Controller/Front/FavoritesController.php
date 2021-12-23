<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Model\Movies;
use App\Service\FavoritesManager;
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
     * <3 Nicolas Lenne
     * 
     * @Route("/favorites/gestion/{id}", name="favorite_gestion", requirements={"id"="\d+"})
     */
    public function favorite(Movie $movie, FavoritesManager $favoritesManager)
    {
        $action = $favoritesManager->toggle($movie);
        
        if ($action == 'add') {
            $this->addFlash('success', $movie->getTitle() . ' ajouté(e) aux favoris');
        } else {
            $this->addFlash('success', $movie->getTitle() . ' retiré(e) des favoris');
        }

        // On redirige vers la home
        return $this->redirectToRoute('favorites_list');
    }

    /**
     * Favorite gestion, vider la liste
     * 
     * @Route("/favorites/gestion/purge", name="favorites_purge")
     */
    public function purgeFavorites(FavoritesManager $favoritesManager)
    {
        // On vide l'attribut de session concerné
        $favoritesManager->empty();

        $this->addFlash('success', 'Favoris supprimés');

        // On redirige vers la liste
        return $this->redirectToRoute('favorites_list');
    }
}
