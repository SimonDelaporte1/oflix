<?php

namespace Faker\Provider;

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
        return $this->role_array[mt_rand(0, count($this->role_array)-1)];
    }
}