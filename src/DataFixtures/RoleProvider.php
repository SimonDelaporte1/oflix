<?php

namespace App\DataFixtures;

class RoleProvider extends \Faker\Provider\Base
{
    private $role_array = array(
        'Le bon',
        'La brute',
        'Le truant',
        'La personne mystere',
        'Le réverbère',
        'Doublure',
        'Figurant'
    );
    public function getRole()
    {
        return $this->role_array[array_rand($this->role_array)];
    }
}