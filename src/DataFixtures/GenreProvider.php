<?php

namespace Faker\Provider;

class GenreProvider extends \Faker\Provider\Base
{
    private $genre_array = array(
        'Sci-fi',
        'Comédie',
        'Drame',
        'Pénible',
        'Mal joué',
        'Epique'
    );
    public function getGenre()
    {
        return $this->genre_array[mt_rand(0, count($this->genre_array)-1)];
    }
}