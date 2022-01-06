<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;
use App\Entity\Casting;

use App\Service\MySlugger;
use Doctrine\DBAL\Connection;
use App\DataFixtures\RoleProvider;

use App\DataFixtures\GenreProvider;
use App\DataFixtures\MovieProvider;
use Doctrine\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    private $connection;
    private $slugger;

    public function __construct(Connection $connection, MySlugger $slugger)
    {
        $this->connection = $connection;
        $this->slugger = $slugger;
    }

    /**
     * Permet de TRUNCATE les tables et de remettre les AI à 1
     */
    private function truncate()
    {
        // On passe en mode SQL ! On cause avec MySQL
        // Désactivation des contraintes FK
        $this->connection->executeQuery('SET foreign_key_checks = 0');
        // On tronque
        $this->connection->executeQuery('TRUNCATE TABLE casting');
        $this->connection->executeQuery('TRUNCATE TABLE genre');
        $this->connection->executeQuery('TRUNCATE TABLE movie');
        $this->connection->executeQuery('TRUNCATE TABLE movie_genre');
        $this->connection->executeQuery('TRUNCATE TABLE person');
        $this->connection->executeQuery('TRUNCATE TABLE review');
        $this->connection->executeQuery('TRUNCATE TABLE season');
        $this->connection->executeQuery('TRUNCATE TABLE user');
        // etc.
    }

    public function load(ObjectManager $manager): void
    {
        // On TRUNCATE manuellement
        $this->truncate();
        
        $faker = Factory::create('fr_FR');

        // pour avoir toujours les mêmes données
        // $faker->seed(2021);

        $faker->addProvider(new RoleProvider($faker));
        $faker->addProvider(new GenreProvider($faker));
        $faker->addProvider(new MovieProvider($faker));
        
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword('$2y$13$j3/Z4Wrfs8siODsmAepFl.sLuH2ci7XQ.i3zQrCnJjs2T0kcLURpG');
        $manager->persist($admin);
        
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('$2y$13$nOoZJpdhcfxWA8srAiUWt.IRPLclO23SWDDGmoW2zz9p6CZYiyCA6');
        $manager->persist($user);
        
        $manager_user = new User();
        $manager_user->setEmail('manager@manager.com');
        $manager_user->setRoles(["ROLE_MANAGER"]);
        $manager_user->setPassword('$2y$13$2sMdkylKKhak5TPCx2kH6OiNhVbRKSnOWfciMKOVZIaIHmFM5RSse');
        $manager->persist($manager_user);
        
        $person_array = [];
        $role_array = [];
        $genre_array = [];
        $movie_array = [];
        for ($i = 0; $i < 8; $i++) {
            $person_array[] = [$faker->firstName(), $faker->lastName()];
        }
        for ($i = 0; $i < 7; $i++) {
            $role_array[] = $faker->getRole();
        }
        for ($i = 0; $i < 7; $i++) {
            $genre_array[] = $faker->getGenre();
        }
        for ($i = 0; $i < 8; $i++) {
            $movie_array[] = $faker->getMovie($i);
        }


        $genreList = [];
        // insertion des genres en BDD
        foreach($genre_array as $this_genre_name){
            $genre = new Genre();
            $genre->setName($this_genre_name);
            $manager->persist($genre);
            $genreList[] = $genre;
        }

        // on rentre les films en BDD. Utile pour initialisé l'objet movie par la suite. On pourrait tout créer dans la même boucle, je préfère par étape c'est plus clair. Et c'est pas comme si il y avait beaucoup de donnée
        $movieList = [];
        $i = 0;
        foreach($movie_array as $this_movie_array) {
            $movie = new Movie();
            $movie->setSummary($this_movie_array['summary']);
            $movie->setSynopsis($this_movie_array['synopsis']);
            $movie->setDuration($this_movie_array['duration']);
            $movie->setType($this_movie_array['type']);
            $movie->setTitle($this_movie_array['title']);
            $movie->setReleaseDate($this_movie_array['release_date']);
            $movie->setPoster($this_movie_array['poster']);
            $movie->setRating($this_movie_array['rating']);

            // genre
            shuffle($genreList);
            foreach ($genreList as $this_genre) {
                $movie->addGenres($this_genre);
                if ($i%mt_rand(1, 7) == 0) {
                    // pour ne pas avoir toujours le même nombre de genre dans un film
                    break;
                }
            }
            $manager->persist($movie);
            $movieList[] = $movie;
            $i++;
        }

        $personList = [];
        // insertion des personnes (acteur) en BDD
        foreach($person_array as $this_person_array){
            $person = new Person();
            $person->setFirstname($this_person_array[0]);
            $person->setLastname($this_person_array[1]);
            $manager->persist($person);
            $personList[] = $person;
        }

        // maintenant que tout est créé, on fait les associations : Saison, Casting
        foreach ($movieList as $this_movie_object) {
            shuffle($role_array);
            shuffle($personList);
            $i=1;
            foreach ($role_array as $this_role_name) {
                $casting = new Casting();
                $casting->setCreditOrder($i);
                $casting->setRole($this_role_name);
                
                $casting->setMovie($this_movie_object);
                $casting->setPerson($personList[$i]);

                $manager->persist($casting);
                $i++;
                if ($i%mt_rand(1, 7) == 0) {
                    // pour ne pas avoir toujours le même nombre d'acteur dans un film
                    break;
                }
            }

            //saison
            if ($this_movie_object->getType() != 'Film') {
                for ($i=1;$i<mt_rand(3, 8);$i++) {
                    $season = new Season();
                    $season->setNumber($i);
                    $season->setEpisodesNumber(mt_rand(2, 10));
                    $season->SetMovie($this_movie_object);
                    $manager->persist($season);
                }
            }
        }
        $manager->flush();
    }
}
