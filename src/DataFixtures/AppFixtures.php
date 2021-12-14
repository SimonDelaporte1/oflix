<?php

namespace App\DataFixtures;

use App\Entity\Casting;
use App\Entity\Movie;
use App\Entity\Person;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $person_array = array(
            array('Brad', 'Pitt'),
            array('Tom', 'Hanks'),
            array('Tom', 'Cruise'),
            array('Alain', 'Delon'),
            array('Emilia', 'Clarke'),
            array('Catherine', 'Deneuve'),
            array('Margot', 'Robbie'),
        );
        $role_array = array(
            array(1, 'Le méchant'),
            array(2, 'Le gentil'),
            array(3, 'Le baggagiste'),
            array(4, 'La personne mystere'),
            array(5, 'L\'atout'),
            array(6, 'doublure'),
            array(7, 'figurant')
        );
        $synopsis_array = array('Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'bla', 'bli', 'je', 'mange', 'des', 'légumes', 'avec', 'de', 'la', 'soupe');
        $summary_array = array('Ceci', 'est', 'une', 'description', 'courte', 'du', 'film', 'que', 'vous', 'allez', 'voir', 'consectetur', 'adipiscing','elit.','Proin','et','aliquet','nibh.','ed','nec','velit','vel','lacus','posuere','dignissim.','Nunc','gravida','auctor','dapibus.','Nulla','faucibus','justo','in','accumsan','laoreet.','Suspendisse','quis','lacinia','tortor.','Cras','auctor','lorem','eget','efficitur','tincidunt.','Vestibulum','ac','eleifend','lectus.','Cras','fringilla','felis','nec','posuere','feugiat.');
        $movie_array = array(
            array('type'=>'Film','title'=>'La moussaka géante','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Série','title'=>'Game of throne','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'100 000 dollars au soleil','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'Jack Reacher','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'Suicide squad','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'un flic','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Série','title'=>'La casa de papel','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Série','title'=>'Narco','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
        );
        foreach($movie_array as $this_movie_array) {
            $movie = new Movie();
            shuffle($synopsis_array);
            shuffle($summary_array);
            $movie->setSummary(implode(' ', $summary_array));
            $movie->setSynopsis(implode(' ', $synopsis_array));
            $movie->setDuration($this_movie_array['duration']);
            $movie->setType($this_movie_array['type']);
            $movie->setTitle($this_movie_array['title']);
            $movie->setReleaseDate($this_movie_array['release_date']);
            $movie->setPoster($this_movie_array['poster']);
            $movie->setRating($this_movie_array['rating']);
            $manager->persist($movie);
        }
        $manager->flush();

        foreach($person_array as $this_person_array){
            $person = new Person();
            $person->setFirstname($this_person_array[0]);
            $person->setLastname($this_person_array[1]);
            $manager->persist($person);
        }
        $manager->flush();
        
        foreach ($movie_array as $this_movie_array) {
            shuffle($role_array);
            $i = 1;
            $MovieRepository = $manager->getRepository(Movie::class);
            $movie = $MovieRepository->findOneBy(['title'=>$this_movie_array['title']]);
            foreach ($role_array as $this_role_array) {
                $casting = new Casting();
                $casting->setCreditOrder($this_role_array[0]);
                $casting->setRole($this_role_array[1]);
                
                $PersonRepository = $manager->getRepository(Person::class);
                $person = $PersonRepository->findAll()[mt_rand(0,6)];
                

                $casting->setMovie($movie);
                $casting->setPerson($person);

                $manager->persist($casting);
                $i++;
                if ($i%mt_rand(1, 7) == 0) {
                    // pour ne pas avoir toujours le même nombre d'acteur dans un film
                    break;
                }
            }
        }

        $manager->flush();
        
    }
}
