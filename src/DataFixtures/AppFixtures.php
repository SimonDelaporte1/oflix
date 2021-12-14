<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Casting;
use App\Entity\Season;
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
           'Le bon',
            'La brute',
            'Le truant',
            'La personne mystere',
            'Le réverbère',
            'Doublure',
            'Figurant'
        );
        $genre_array = array(
            'Sci-fi',
            'Comédie',
            'Drame',
            'Pénible',
            'Mal joué',
            'Epique'
        );
        $synopsis_array = array('Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'bla', 'bli', 'je', 'mange', 'des', 'légumes', 'avec', 'de', 'la', 'soupe');
        $summary_array = array('Ceci', 'est', 'une', 'description', 'courte', 'du', 'film', 'que', 'vous', 'allez', 'voir', 'consectetur', 'adipiscing','elit.','Proin','et','aliquet','nibh.','ed','nec','velit','vel','lacus','posuere','dignissim.','Nunc','gravida','auctor','dapibus.','Nulla','faucibus','justo','in','accumsan','laoreet.','Suspendisse','quis','lacinia','tortor.','Cras','auctor','lorem','eget','efficitur','tincidunt.','Vestibulum','ac','eleifend','lectus.','Cras','fringilla','felis','nec','posuere','feugiat.');

        // summary et synopsis seront ajouté au dernier moment, pour faire un shuffle sur ces tableaux à chaque itération
        $movie_array = array(
            array('type'=>'Film','title'=>'L’Attaque de la Moussaka géante','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Série','title'=>'Game of throne','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'100 000 dollars au soleil','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'Jack Reacher','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'Suicide squad','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Film','title'=>'Un flic','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Série','title'=>'La casa de papel','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
            array('type'=>'Série','title'=>'Narco','release_date'=>new DateTime(mt_rand(1900,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,12)),'duration'=>mt_rand(60,220),'poster'=>'https://picsum.photos/200/300','rating'=>mt_rand(1,5)),
        );
        // on rentre les films en BDD. Utile pour initialisé l'objet movie par la suite. On pourrait tout créer dans la même boucle, je préfère par étape c'est plus clair. Et c'est pas comme si il y avait beaucoup de donnée
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

        // intersion des personnes (acteur) en BDD
        foreach($person_array as $this_person_array){
            $person = new Person();
            $person->setFirstname($this_person_array[0]);
            $person->setLastname($this_person_array[1]);
            $manager->persist($person);
        }
        $manager->flush();
  
        // insertion des genres en BDD
        foreach($genre_array as $this_genre_name){
            $genre = new Genre();
            $genre->setName($this_genre_name);
            $manager->persist($genre);
        }
        $manager->flush();
              

        // maintenant que tout est créé, on fait les associations : Saison, Casting et Genre
        foreach ($movie_array as $this_movie_array) {
            shuffle($role_array);
            $MovieRepository = $manager->getRepository(Movie::class);
            $movie = $MovieRepository->findOneBy(['title'=>$this_movie_array['title']]);
            $i=1;
            foreach ($role_array as $this_role_name) {
                $casting = new Casting();
                $casting->setCreditOrder($i);
                $casting->setRole($this_role_name);
                
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

            // genre
            $GenreRepository = $manager->getRepository(Genre::class);
            $genreList = $GenreRepository->findAll();
            shuffle($genreList);
            foreach ($genreList as $this_genre) {
                $movie->addGenre($this_genre);
                if ($i%mt_rand(1, 7) == 0) {
                    // pour ne pas avoir toujours le même nombre de genre dans un film
                    break;
                }
            }
            $manager->persist($movie);

            //saison
            if ($this_movie_array['type'] == 'Série') {
                for ($i=1;$i<20;$i++) {
                    $season = new Season();
                    $season->setNumber($i);
                    $season->setEpisodesNumber(mt_rand(2, 10));
                    $season->SetMovie($movie);
                    $manager->persist($season);
                    if ($i%mt_rand(1, 20) == 0) {
                        // pour ne pas avoir toujours le même nombre de saison pour les séries
                        break;
                    }
                }
            }
            $manager->flush();
        }
    }
}
