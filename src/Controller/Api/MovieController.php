<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\ORM\EntityManager;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

class MovieController extends AbstractController
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
     * Post one movie
     * 
     * @Route("/api/movies", name="api_movies_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine, GenreRepository $genreRepository): Response
    {
        // @todo : retourner les films de la BDD
        $jsonContent = $request->getContent();
        // On va chercher les données
        /*
            $arrayContent = json_decode($jsonContent, true);

            $thisGenre = $genreRepository->find($arrayContent['genres'][0]['id']);
            $genre = new Genre();
            $genre->setName($thisGenre->getName());
            $movie->addGenres($genre);
        */
        
        $movie = $serializer->deserialize($jsonContent, Movie::class, 'json');

        $errors = $validator->validate($movie);
        if (count($errors) > 0) {
            // @todo Retourner des erreurs de validation propres
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($movie);
        // On exécute les requêtes SQL
        $entityManager->flush();
        
        return $this->json(
            // Le film créé peut être ajouté au retour
            $movie,
            // Le status code : 201 CREATED
            // utilisons les constantes de classes !
            Response::HTTP_CREATED,
            // REST demande un header Location + URL de la ressource
            [
                // Nom de l'en-tête + URL
                'Location' => $this->generateUrl('api_movie_get', ['id' => $movie->getId()])
            ],
            // Groups
            ['groups' => 'get_movie']
        );
    }

    /**
     * 
     * Get one movie item
     * 
     * @Route("/api/movies/{id<\d+>}", name="api_movie_get", methods={"GET"})
     */
    public function getMovie(Movie $movie): Response
    {
        // @todo : retourner les films de la BDD

        return $this->json(
            // Les données à sérialiser (à convertir en JSON)
            $movie,
            // Le status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_movie']
        );
    }

    /**
     * Get random movie
     * 
     * @Route("/api/movies/random", name="api_movie_rand_get", methods={"GET"})
     */
    public function getRandMovie(MovieRepository $movieRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $movie = $movieRepository->findOneRandomMovie();
        return $this->json( 
            // Les données à sérialiser (à convertir en JSON)
            $movie
        );
    }
}
