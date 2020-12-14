<?php 

namespace App\Tests\Functional;

use App\ApiPlatform\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use App\Entity\User;
use App\Test\CustomApiTestCase;

class UserResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    /**
     * undocumented function
     *
     * @return void
     */
    public function testCreateUser()
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'cheeseplease@example.com',
                'username' => 'cheeseplease',
                'password' => 'brie',
            ],
        ]);
        $this->assertResponseStatusCodeSame(201); // 

        $this->login($client, 'cheeseplease@example.com', 'brie');
        /*
        $this->createUserAndLogin($client, 'cheeseplease@example.com', 'foo');
        $client->request('POST', '/api/users', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(400); // Bad request
         */
    }

    public function testUpdateUser()
    {
      /*
        $client = self::createClient();
        $user1 = $this->createUser('user1@example.com', 'foo');
        $user2 = $this->createUser('user2@example.com', 'foo');

        $user = new User('Block of cheedar');

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        $this->login($client, 'user2@example.com', 'foo');
        $client->request('PUT', '/api/users/'.$user->getId(), [
            'json' => ['title' => 'updated', 'owner' => '/api/users/'.$user2->getId()],
        ]);
        $this->assertResponseStatusCodeSame(403);
        //var_dump($client->getResponse()->getContent(false));

        $this->login($client, 'user1@example.com', 'foo');
        $client->request('PUT', '/api/users/'.$user->getId(), [
            'json' => ['title' => 'updated'],
        ]);
        $this->assertResponseStatusCodeSame(200);
       */

    }

}
