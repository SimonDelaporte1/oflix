<?php

namespace App\Tests\Controller\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAccessTest extends WebTestCase
{
    /**
     * Routes en GET pour Anonymous
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
     * Routes en GET pour Anonymous
     * 
     * @dataProvider ManagerUrlsAuthorizedList
     */
    public function testPagesManagerAuthorizedList($urlOk)
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
     * Routes en GET pour Anonymous
     * 
     * @dataProvider ManagerUrlsForbiddenGetList
     */
    public function testPagesManagerForbiddenGetList($urlNok)
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
     * Routes en GET pour Anonymous
     * 
     * @dataProvider ManagerUrlsForbiddenPostList
     */
    public function testPagesManagerForbiddenPostList($urlNok)
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
     * Routes en GET pour Anonymous
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
     * Routes en GET pour Anonymous
     * 
     * @dataProvider UrlsListAdminPostWithRedirection
     */
    public function testPagesAdminPostWithRedirection($url)
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // On récupère admin@admin.com
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('POST', $url);
        $this->assertResponseStatusCodeSame(200);
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
}