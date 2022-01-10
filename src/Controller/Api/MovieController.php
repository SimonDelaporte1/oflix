<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/api/secure/movies", name="api_movies_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ManagerRegistry $doctrine): Response
    {
        // @todo : retourner les films de la BDD
        $jsonContent = $request->getContent();
        // On va chercher les données
        /*
            $arrayContent = json_decode($jsonContent, true);

            $thisGenre = $genreRepository->find($arrayContent['genres'][0]['id']);
            $genre = new Genre();
            $genre->setName($thisGenre->getName());
            $movie = $serializer->deserialize($jsonContent, Movie::class, 'json');

            $movie->addGenres($genre);
        */
        // dd(json_decode($jsonContent, true));
        
        try {
            // Désérialiser (convertir) le JSON en entité Doctrine Movie
            $movie = $serializer->deserialize($jsonContent, Movie::class, 'json');
            //dd($movie);
        
        } catch (NotEncodableValueException $e) {
            return $this->json(
                ['error' => 'JSON invalide'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // Valider l'entité
        // @link : https://symfony.com/doc/current/validation.html#using-the-validator-service
        $errors = $validator->validate($movie);
        // Y'a-t-il des erreurs ?
        if (count($errors) > 0) {
            // tableau de retour
            $errorsClean = [];
            // @Retourner des erreurs de validation propres
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorsClean[$error->getPropertyPath()][] = $error->getMessage();
            };

            return $this->json($errorsClean, Response::HTTP_UNPROCESSABLE_ENTITY);
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
    public function getMovie(Movie $movie = null): Response
    {
        // @todo : retourner les films de la BDD
        // 404 ?
        if ($movie === null) {
            return $this->json(['error' => 'Film non trouvé.'], Response::HTTP_NOT_FOUND);
        }
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
        // $movie = $movieRepository->findOneRandomMovie();
        $movie = $movieRepository->findOneRandomMovieDql();

        return $this->json(
            $movie,
            Response::HTTP_OK,
            [],
            ['groups' => 'get_movie']
        );
    }
}
