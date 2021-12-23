<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Manage user favorites movies and series
 * 
 * - Add/Remove or Toggle
 * - Empty
 * - storage : Session
 */
class FavoritesManager
{
    // @link https://symfony.com/doc/current/session.html#basic-usage
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function empty()
    {
        $this->session->remove('myFavorites');
    }

    /**
     * Add or Remove a movie from the list
     */
    public function toggle($movie)
    {
        // 1. On récupère les favoris en session, ou un tableau vide sinon
        $myFavorites = $this->session->get('myFavorites', []);

        // 2. On met à jour le tableau récupéré

        // Si l'index du film est déjà dans les favoris
        if (array_key_exists($movie->getId(), $myFavorites)) {
            // On le retire via PHP unset(élément)
            unset($myFavorites[$movie->getId()]);
            // Action à retourner au contrôleur
            $action = 'remove';
        } else {
            // Sinon on l'ajoute
            $myFavorites[$movie->getId()] = $movie;
            // Action à retourner au contrôleur
            $action = 'add';
        }

        // 3. On écrase les favoris en session
        $this->session->set('myFavorites', $myFavorites);

        return $action;
    }
}