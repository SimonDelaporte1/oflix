<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\GenreRepository;
// un use est nécessaire pour les @route
use App\Repository\MovieRepository;
use App\Repository\CastingRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

Class MainController extends AbstractController
{
    /** 
     * @Route("/movie/review/{id<\d+>}", name="main_movie_review_add", methods={"GET", "POST"})
     */
    public function review(int $id, Movie $movie, ManagerRegistry $doctrine, Request $request)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);

        // Le Form inspecte la Requête
        $form->handleRequest($request);

        // Si le form a été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $review->setMovie($movie);
            // On va faire appel au Manager de Doctrine
            $entityManager = $doctrine->getManager();
            // Prépare-toi à "persister" notre objet (req. INSERT INTO)
            $entityManager->persist($review);

            // On exécute les requêtes SQL
            $entityManager->flush();

            //dd($post);

            // On redirige vers la liste
            return $this->redirectToRoute('main_movie_show', ['slug' => $movie->getSlug()]);
        }

        // Sinon on affiche le formulaire
        return $this->renderForm('front/main/review.html.twig', [
            'form' => $form,
            'movie' => $movie,
        ]);
    }
    
    /** 
     * @Route("/", name="main_home")
     */
    public function home(MovieRepository $MovieRepository, GenreRepository $GenreRepository)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesList = $MovieRepository->findAllOrderedByDateAscQb();
        $genreList = $GenreRepository->findAll();
        return $this->render('front/main/home.html.twig', [
            'moviesList' => $moviesList,
            'genreList' => $genreList
        ]);
    }

    /** 
     * @Route("/movie/{slug}", name="main_movie_show")
     */
    public function movieShow(Movie $movie = null, CastingRepository $CastingRepository)
    {
        if($movie === null) {
            throw $this->createNotFoundException('Film ou série non trouvé.');
        }
        $casting = $CastingRepository->findAllJoinedToCastingQb($movie->getId());
        // dd($movie);
        return $this->render('front/main/movieShow.html.twig', [
            'movie' => $movie,
            'casting' => $casting
        ]);
    }


    /** 
     * @Route("/movies/list", name="main_movie_list")
     */
    public function list(MovieRepository $MovieRepository)
    {
        // on rend un template twig à partir du dossier templates/
        $moviesList = $MovieRepository->findAllOrderedByTitleAscQb();
        return $this->render('front/main/movieList.html.twig', [
            'moviesList' => $moviesList
        ]);
    }

    /** 
     * 
     * theme switcher
     * 
     * @Route("/theme/toggle", name="main_theme_switcher")
     */
    public function themeSwitcher(SessionInterface $session)
    {
        // notre but est de stocker en session utilisateur le theme choisi
        
        // on récupère le theme de la session
        $theme = $session->get('theme', 'netflix');

        // on inverse le theme
        if($theme === 'netflix' ) {
            $session->set('theme', 'allocine');
        } else{
            $session->set('theme', 'netflix');
        }

        // on redirige vers la home
        return $this->redirectToRoute('main_home');

        // puis dans le template base.html.twig on conditionnera le CSS de la nav selon le theme choisi
    }
}