<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * Get movies collection
     * 
     * @Route("/api/movies", name="api_movies_get", methods={"GET"})
     */
    public function getCollection(MovieRepository $movieRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $moviesList = $movieRepository->findAll();

        return $this->json(
            // Les données à sérialiser (à convertir en JSON)
            $moviesList,
            // Le status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_collection']
        );
    }

    /**
     * 
     * Get one movie item
     * 
     */
}
