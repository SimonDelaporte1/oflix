<?php

namespace App\EventSubscriber;

use App\Repository\MovieRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment as Twig;


class RandomMovieSubscriber implements EventSubscriberInterface
{
    /**
     * Service MovieRepository
     */
    private $movieRepository;

    /**
     * Service Twig
     */
    private $twig;

    public function __construct(MovieRepository $movieRepository, Twig $twig)
    {
        $this->movieRepository = $movieRepository;
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $randomMovie = $this->movieRepository->findOneRandomMovie();
        dump('RandomMovieSubscriber appelé');
        $this->twig->addGlobal('randomMovie', $randomMovie);
    }

    public static function getSubscribedEvents()
    {
        return [
            // type d'événement => méthode à appeler
            'kernel.controller' => 'onKernelController',
        ];
    }
}
