<?php

namespace App\Controller;

use DateTime;
use App\Entity\Movie;
use App\Entity\Season;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test/movie/create", name="test_movie_create")
     */
    public function create(ManagerRegistry $doctrine): Response
    {
        // on créer une entité Doctrine
        $movie = new Movie;
        $movie->setTitle('Avatar');
        $movie->setType('Film');
        $movie->setReleaseDate(new DateTime('2009-12-24'));
        dump($movie);

        // On va faire appel au Manager de Doctrine
        $entityManager = $doctrine->getManager();
        // Prépare-toi à "persister" notre objet
        $entityManager->persist($movie);

        // enregistre en BDD
        $entityManager->flush();

        dd($movie);
    }

    /**
     * @Route("/test/movie/list")
     */
    public function list(MovieRepository $MovieRepository)
    {
        $moviesList = $MovieRepository->findAll();

        dd($moviesList);
    }

    /**
     * @Route("/test/movie/{id}")
     */
    public function show($id, MovieRepository $MovieRepository)
    {
        $movie = $MovieRepository->find($id);

        dd($movie);
    }


    /**
     * @Route("/test/movie/update/{id}", requirements={"id"="\d+"})
     */
    public function update($id, MovieRepository $MovieRepository, ManagerRegistry $doctrine)
    {
        $movie = $MovieRepository->find($id);

        $movie->setTitle('Avatar'. mt_rand(3,99));

        $entityManager = $doctrine->getManager();

        $entityManager->flush();

        dd($movie);
    }

    /**
     * @Route("/test/movie/delete/{id}", requirements={"id"="\d+"})
     */
    public function delete($id, MovieRepository $MovieRepository, ManagerRegistry $doctrine)
    {
        //
        $movie = $MovieRepository->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($movie);
        $entityManager->flush();

        dd($movie);
    }

    /**
     * 
     * Création de saison et ajout à une série existante
     * @Route("/test/season/add")
     * 
     */
    public function seasonAdd(MovieRepository $MovieRepository, ManagerRegistry $doctrine) {
        // on va récupérer la série voulu
        $xfiles = $MovieRepository->find(1);

        $season = new Season;

        $season->setNumber(3);
        $season->setEpisodesNumber(15);
        // La série associée
        $season->SetMovie($xfiles);


        // entity manager de Doctrine
        $entityManager = $doctrine->getManager();
        // On persiste $season
        $entityManager->persist($season);
        $entityManager->flush();

        dd($season);
    }
}
