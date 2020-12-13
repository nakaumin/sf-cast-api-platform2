<?php

namespace App\Test;
use App\ApiPlatform\Test\ApiTestCase;
use App\ApiPlatform\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CustomApiTestCase extends ApiTestCase
{
    /**
     * undocumented function
     *
     * @return void
     */
    protected function name($param)
    {
        return null;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    protected function createUser(string $email,  string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername(substr($email, 0, strpos($email, '@')));

        $encoded = self::$container->get('security.password_encoder')
           ->encodePassword($user, $password);
        $user->setPassword($encoded);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    protected function login(Client $client, string $email,  string $password)
    {
        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    protected function createUserAndLogin(Client $client, string $email,  string $password): User
    {
        $user = $this->createUser($email, $password);

        $this->login($client, $email, $password);

        return $user;
    }

    /**
     * undocumented function
     *
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$container->get('doctrine')->getManager();
    }

}
