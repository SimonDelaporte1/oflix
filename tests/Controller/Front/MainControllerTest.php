<?php

namespace App\Tests\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    /**
     * Home
     */
    public function testHome(): void
    {
        // On crée un client
        $client = static::createClient();
        // On exécute une requête HTTP en GET sur l'URL /
        $crawler = $client->request('GET', '/');

        // A-t-on un status code entre 200 et 299
        $this->assertResponseIsSuccessful();
        // Est-on sur la home ?
        $this->assertSelectorTextContains('h1', 'Films, séries TV et popcorn en illimité.');
    }

    /**
     * Movie show
     */
    public function testMovieShow(): void
    {
        // On crée un client
        $client = static::createClient();
        // On exécute une requête HTTP en GET sur l'URL /film-1
        $crawler = $client->request('GET', '/movie/film-1');

        // Status code 200
        $this->assertResponseStatusCodeSame(200);

        // Est-on sur la home ?
        $this->assertSelectorTextContains('h3', 'Film 1');
    }

    /**
     * Anonymous Add Review
     */
    public function testAnonymousReviewAdd()
    {
        // On crée un client
        $client = static::createClient();
        // On exécute une requête HTTP en GET sur l'URL /film-1
        $crawler = $client->request('GET', '/movie/review/1');

        // On doit avoir une redirection (status code 302)
        $this->assertResponseStatusCodeSame(302);
    }

    /**
     * ROLE_USER Add Review
     */
    public function testRoleUserReviewAdd(): void
    {
        // On crée un client
        $client = static::createClient();

        // Le Repo des Users
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère user@user.com
        $testUser = $userRepository->findOneByEmail('user@user.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // On exécute une requête HTTP en GET sur l'URL /film-1
        $crawler = $client->request('GET', '/movie/review/1');

        // Status code 200 (OK !)
        $this->assertResponseStatusCodeSame(200);
        
        $this->assertSelectorTextContains('h1', 'Poster votre avis');
    }

    /**
     * Ajouter une critique en POST 
     */
    public function testSuccessSubmittingform(): void
    {
        $client = static::createClient();
        // Le Repo des Users
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère user@user.com
        $testUser = $userRepository->findOneByEmail('user@user.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler =  $client->request('GET', '/movie/review/1');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('submit_review');
        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['review[username]'] = 'Simon';
        $form['review[email]'] = 'contact@simondelaporte.com';
        $form['review[content]'] = 'Symfony rocks!';
        $form['review[rating]'] = '3';
        $form['review[reactions]'] = ['smile', 'cry'];
        $form['review[watchedAt][month]'] = '1';
        $form['review[watchedAt][day]'] = '15';
        $form['review[watchedAt][year]'] = '2022';

        // submit the Form object
        $client->submit($form);

        $this->assertResponseStatusCodeSame(302);
    }

    /**
     * Ajouter une critique en POST 
     */
    public function testErrorSubmittingform(): void
    {
        $client = static::createClient();
        // Le Repo des Users
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère user@user.com
        $testUser = $userRepository->findOneByEmail('user@user.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler =  $client->request('GET', '/movie/review/1');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('submit_review');
        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['review[username]'] = '';
        $form['review[email]'] = 'contact@simondelaporte.com';
        $form['review[content]'] = 'Symfony rocks!';
        $form['review[rating]'] = '3';
        $form['review[reactions]'] = ['smile', 'cry'];
        $form['review[watchedAt][month]'] = '1';
        $form['review[watchedAt][day]'] = '15';
        $form['review[watchedAt][year]'] = '2022';

        // submit the Form object
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
    }
}