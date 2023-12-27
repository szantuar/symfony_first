<?php

namespace App\DataFixtures;

use App\Entity\Autor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AutorFixtures extends Fixture
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function load(ObjectManager $manager): void
    {

        $response = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/users'
        );
    
        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {

            $content = $response->getContent();
            $content = $response->toArray();


            $i = 1;
            
            foreach($content AS $listAutor) {
                $autor = new Autor();

                $autor->setName($listAutor['name']);
                $manager->persist($autor);

                $manager->flush(); 
                $autor_id = 'autor_' . $i;

                $this->addReference($autor_id, $autor);
                $i++;
                
            }

            
            
        }



       
    }
}
