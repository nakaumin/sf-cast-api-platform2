<?php 

namespace App\Tests\Functional;

use App\ApiPlatform\Test\ApiTestCase;
use App\Entity\CheeseListing;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use App\Entity\User;
use App\Test\CustomApiTestCase;

class CheeseListingResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    /**
     * undocumented function
     *
     * @return void
     */
    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request('POST', '/api/cheeses', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogin($client, 'cheeseplease@example.com', 'foo');
        $client->request('POST', '/api/cheeses', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(400);
    }

    public function testUpdateCheeseListing()
    {
        $client = self::createClient();
        $user1 = $this->createUser('user1@example.com', 'foo');
        $user2 = $this->createUser('user2@example.com', 'foo');

        $cheesListing = new CheeseListing('Block of cheedar');
        $cheesListing->setOwner($user1);
        $cheesListing->setPrice(1000);
        $cheesListing->setDescription('mmmm');

        $em = $this->getEntityManager();
        $em->persist($cheesListing);
        $em->flush();

        $this->login($client, 'user2@example.com', 'foo');
        $client->request('PUT', '/api/cheeses/'.$cheesListing->getId(), [
            'json' => ['title' => 'updated', 'owner' => '/api/users/'.$user2->getId()],
        ]);
        $this->assertResponseStatusCodeSame(403);
        //var_dump($client->getResponse()->getContent(false));

        $this->login($client, 'user1@example.com', 'foo');
        $client->request('PUT', '/api/cheeses/'.$cheesListing->getId(), [
            'json' => ['title' => 'updated'],
        ]);
        $this->assertResponseStatusCodeSame(200);

    }

}

