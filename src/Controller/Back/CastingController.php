<?php

namespace App\Controller\Back;

use App\Entity\Movie;
use App\Entity\Casting;
use App\Form\CastingType;
use App\Repository\CastingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/casting")
 */
class CastingController extends AbstractController
{
    /**
     * @Route("/movie/{id}", name="back_casting_index", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function index(Movie $movie, CastingRepository $castingRepository): Response
    {
        return $this->render('back/casting/index.html.twig', [
            'castings' => $castingRepository->findAllJoinedToCastingQb($movie),
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/new/movie/{id}", name="back_casting_new", methods={"GET", "POST"})
     */
    public function new(Movie $movie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $casting = new Casting();
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $casting->setMovie($movie);
            $entityManager->persist($casting);
            $entityManager->flush();

            // On associe le film au casting

            $this->addFlash(
                'success', 'Casting créé'
            );
            return $this->redirectToRoute('back_casting_index', ['id' => $movie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/casting/new.html.twig', [
            'casting' => $casting,
            'form' => $form,
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}", name="back_casting_show", methods={"GET"})
     */
    public function show(Casting $casting): Response
    {
        return $this->render('back/casting/show.html.twig', [
            'casting' => $casting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_casting_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Casting $casting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CastingType::class, $casting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success', 'Casting modifié'
            );
            return $this->redirectToRoute('back_casting_index', ['id' => $casting->getMovie()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/casting/edit.html.twig', [
            'casting' => $casting,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_casting_delete", methods={"POST"})
     */
    public function delete(Request $request, Casting $casting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$casting->getId(), $request->request->get('_token'))) {
            $entityManager->remove($casting);
            $entityManager->flush();
            $this->addFlash(
                'success', 'Casting supprimé'
            );
        }

        return $this->redirectToRoute('back_casting_index', ['id' => $casting->getMovie()->getId()], Response::HTTP_SEE_OTHER);
    }
}
