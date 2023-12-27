<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PostsFixtures extends Fixture
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $response = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/posts'
        );
    
        $statusCode = $response->getStatusCode();
        
        if ($statusCode == 200) {

            $content = $response->getContent();
            $content = $response->toArray();          
            
            foreach($content AS $listPosts) {

                $post = new Posts();

                $post->setTitle($listPosts['title']);
                $post->setContent($listPosts['body']);

                $autor_id = 'autor_' . $listPosts['userId'];
                $post->setAutor($this->getReference($autor_id));

                $manager->persist($post);

                $manager->flush();
            }
        }
       
    }
}
