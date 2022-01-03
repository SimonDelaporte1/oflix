<?php

namespace App\Controller\Back;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Service\MySlugger;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/movie")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="back_movie_index", methods={"GET"})
     */
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('back/movie/index.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_movie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, MySlugger $slugger): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie->setSlug($slugger->MySluggerToLower($movie->getTitle()));
            $entityManager->persist($movie);
            $entityManager->flush();
            $this->addFlash(
                'success', 'Film "'.$movie->getTitle().'" ajouté'
            ); 
       
            return $this->redirectToRoute('back_movie_show', ['id' => $movie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_movie_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Movie $movie = null): Response
    {
        if ($movie === null) {
            throw $this->createNotFoundException('Film non trouvé.');
        }
        return $this->render('back/movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_movie_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Movie $movie, EntityManagerInterface $entityManager, MySlugger $slugger): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($movie === null) {
            throw $this->createNotFoundException('Film non trouvé.');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $movie->setSlug($slugger->MySluggerToLower($movie->getTitle()));
            $entityManager->flush();

            $this->addFlash(
                'success', 'Film "'.$movie->getTitle().'" modifié'
            );
            return $this->redirectToRoute('back_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_movie_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($movie === null) {
            throw $this->createNotFoundException('Film non trouvé.');
        }
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {

            $this->addFlash(
                'success', 'Film "'.$movie->getTitle().'" supprimé'
            );
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_movie_index', [], Response::HTTP_SEE_OTHER);
    }
}
