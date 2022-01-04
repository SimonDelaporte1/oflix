<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Classe d'accès à l'API d'omdbapi.com
 */
class OmdbApi
{  
      // Les services nécessaires
    // On utilise le composant HttpClient de Symfony
    // @link https://symfony.com/doc/current/http_client.html
    private $httpClient;
    // Pour récupérer les paramètres de services.yaml (mais pas que !) depuis notre code
    private $parameterBag;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $parameterBag)
    {
        $this->httpClient = $httpClient;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Renvoie le contenu JSON du film demandé
     * 
     * @param string $title Movie title
     */
    public function fetch(string $title)
    {
        // On envoie une requête chez omdbapi.com
        // @link https://symfony.com/doc/current/http_client.html#query-string-parameters

        $response = $this->httpClient->request(
            'GET',
            'https://www.omdbapi.com/',
            [
                'query' => [
                    't' => $title, // urlencode() sera appliqué dessus
                    'apiKey' => $this->parameterBag->get('app.omdb_api_key'),
                ]
            ]
        );


        $responseArray = $response->toArray();

        return $responseArray;
    }

    /**
     * Renvoie l'URL du poster d'un film donné
     * 
     * @param string $title Movie title
     * 
     * @return string Poster's URL
     */
    public function fetchPoster(string $title)
    {
        $content = $this->fetch($title);
       
        if (!array_key_exists('Poster', $content)) {
            return '';
        }

        return $content['Poster'];
    }
}