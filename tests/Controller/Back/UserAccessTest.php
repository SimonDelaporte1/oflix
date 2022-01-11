<?php

namespace App\Tests\Controller\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAccessTest extends WebTestCase
{
    /**
     * Routes interdites back office en GET pour ROLE_USER
     * 
     * @dataProvider UrlsList
     */
    public function PagesRoleUser($url)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère user@user.com
        $testUser = $userRepository->findOneByEmail('user@user.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', $url);
        
        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * Routes autorisées back office en GET pour ROLE_MANAGER
     * 
     * @dataProvider ManagerUrlsAuthorizedList
     */
    public function testPagesManagerAuthorized($urlOk)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère manager@manager.com
        $testUser = $userRepository->findOneByEmail('manager@manager.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', $urlOk);
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * Routes interdites back office en GET pour ROLE_MANAGER
     * 
     * @dataProvider ManagerUrlsForbiddenGetList
     */
    public function testPagesManagerForbiddenGet($urlNok)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère manager@manager.com
        $testUser = $userRepository->findOneByEmail('manager@manager.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', $urlNok);
        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * Routes interdites back office en POST pour ROLE_MANAGER
     * 
     * @dataProvider ManagerUrlsForbiddenPostList
     */
    public function testPagesManagerForbiddenPost($urlNok)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère manager@manager.com
        $testUser = $userRepository->findOneByEmail('manager@manager.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('POST', $urlNok);
        $this->assertResponseStatusCodeSame(403);
    }

    /**
     * Routes autorisées back office en GET pour ROLE_ADMIN
     * 
     * @dataProvider UrlsList
     */
    public function testPagesAdmin($url)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère admin@admin.com
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', $url);
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * Routes pour "new" pour ROLE_ADMIN
     * 
     * @dataProvider postUrlsNew
     */
    public function testPagePostIsUnprocessable($url)
    {
        // On crée un client
        $client = static::createClient();

        // Le Repo des Users
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère admin@admin.com
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // On exécute la requête APRES être loggué
        $client->request('GET', $url);

        // On affiche le form
        $this->assertResponseStatusCodeSame(200);

        // On soumet le form vide
        $crawler = $client->submitForm('Enregistrer');

        // Le ROLE_ADMIN aura un status code 422
        $this->assertResponseStatusCodeSame(422);
        // ou $this->assertResponseIsUnprocessable();
    }

    /**
     * Routes autorisées back office en POST pour ROLE_ADMIN avec redirections
     * 
     * @dataProvider postUrlsEditDelete
     */
    public function testPagePostIsSeeOther($url)
    {
        // On crée un client
        $client = static::createClient();

        // Le Repo des Users
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère admin@admin.com
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // On exécute la requête APRES être loggué
        $client->request('GET', $url);

        // On affiche le form
        $this->assertResponseStatusCodeSame(200);

        // On soumet le form vide
        $crawler = $client->submitForm('Mettre à jour');

        // Le ROLE_ADMIN aura un status code 303
        $this->assertResponseStatusCodeSame(303);
        // ou $this->assertResponseRedirects();
    }
    
    public function postUrlsEditDelete()
    {
        yield ['/back/casting/1/edit'];
        // yield ['/back/casting/1'];
        yield ['/back/movie/1/edit'];
        // yield ['/back/movie/1'];
        yield ['/back/user/1/edit'];
        // yield ['/back/user/1'];
        // ...
    }

    public function postUrlsNew()
    {
        yield ['/back/casting/new/movie/1'];
        yield ['/back/movie/new'];
        yield ['/back/user/new'];
        // ...
    }

    public function ManagerUrlsForbiddenGetList()
    {
        yield ['/back/casting/1/edit'];
        yield ['/back/movie/new'];
        yield ['/back/movie/1/edit'];
        yield ['/back/user/new'];
        yield ['/back/user/1/edit'];
    }
    
    public function ManagerUrlsForbiddenPostList()
    {
        yield ['/back/casting/1'];
        yield ['/back/casting/new/movie/1'];
        yield ['/back/movie/1'];
        yield ['/back/user/1'];
        // ...
    }

    public function ManagerUrlsAuthorizedList()
    {
        yield ['/back/casting/1'];
        yield ['/back/casting/movie/1'];
        yield ['/back/movie/'];
        yield ['/back/movie/1'];
        yield ['/back/user/'];
        yield ['/back/user/1'];
        // ...
    }

    public function UrlsListAdminPostWithRedirection()
    {
        yield ['/back/casting/1/edit'];
        yield ['/back/movie/1/edit'];
        yield ['/back/movie/new'];
        yield ['/back/user/new'];
        yield ['/back/user/1/edit'];
        // ...
    }
    public function UrlsList()
    {
        yield ['/back/casting/1'];
        yield ['/back/casting/1/edit'];
        yield ['/back/casting/movie/1'];
        yield ['/back/casting/new/movie/1'];
        yield ['/back/movie/'];
        yield ['/back/movie/new'];
        yield ['/back/movie/1'];
        yield ['/back/movie/1/edit'];
        yield ['/back/user/'];
        yield ['/back/user/new'];
        yield ['/back/user/1'];
        yield ['/back/user/1/edit'];
        // ...
    }
    /**
     * Idem pour DELETE mais Bouton = "Supprimer"
     * 
     * /!\ Souci : les éléments seront vraiment supprimés
     * de la BDD de test et donc le test suivant échouera
     * 
     * Solution ce bundle : https://symfony.com/doc/current/testing.html#resetting-the-database-automatically-before-each-test
     * ou recharger les Fixtures de test avant chaque test
     */
}