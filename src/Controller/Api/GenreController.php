<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Repository\MovieRepository;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
    /**
     * Get genres
     * 
     * @Route("/api/genres", name="api_genres_get", methods={"GET"})
     */
    public function getGenres(GenreRepository $genreRepository): Response
    {
        // @todo : retourner les films de la BDD
        
        // On va chercher les données
        $genreList = $genreRepository->findAll();

        return $this->json(
            // Les données à sérialiser (à convertir en JSON)
            $genreList,
            // Le status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_genre']
        );
    }

    /**
     * 
     * Get one genre item
     * 
     * @Route("/api/genres/{id<\d+>}", name="api_genre_get", methods={"GET"})
     */
    public function getGenre(Genre $genre): Response
    {
        // @todo : retourner les films de la BDD

        return $this->json(
            // Les données à sérialiser (à convertir en JSON)
            $genre,
            // Le status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_genre']
        );
    }

    /**
     * 
     * Get movies by genre
     * 
     * @Route("/api/genres/{id<\d+>}/movies", name="api_genre_movie_get", methods={"GET"})
     */
    public function getGenreMovie(Genre $genre, MovieRepository $movieRepository): Response
    {
        // @todo : retourner les films de la BDD
        // dd($genre->getId());
        // $moviesList = $movieRepository->findByGenre($genre->getId());
        
        $moviesList = $genre->getMovies();
        
        return $this->json(
            // Les données à sérialiser (à convertir en JSON)
            $moviesList,
            // Le status code
            200,
            // Les en-têtes de réponse à ajouter (aucune)
            [],
            // Les groupes à utiliser par le Serializer
            ['groups' => 'get_movie']
        );
    }
}
