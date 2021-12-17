<?php

namespace App\Controller\Front;

use App\Model\Movies;
use App\Repository\MovieRepository;
use Symfony\Component\Routing\Annotation\Route;
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
}
