<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class MySlugger
{
    private $slugger;
    private $lowerEnabled;

    public function __construct(SluggerInterface $slugger, bool $lowerEnabled)
    {
        $this->slugger = $slugger;
        $this->lowerEnabled = $lowerEnabled;
    }

    public function MySluggerToLower ($string)
    {
        // Le service est-il configuré pour autorisé le lower case ?
        if (!$this->lowerEnabled) {
            return $this->slugger->slug($string);
        } else {
            return $this->slugger->slug($string)->lower();
        }
    }
}