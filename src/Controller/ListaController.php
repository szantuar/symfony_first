<?php

namespace App\Controller;

use App\Repository\AutorRepository;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListaController extends AbstractController
{
    private $em;
    private $postsRepository;
    private $autorRepository;

    public function __construct(PostsRepository $postsRepository, EntityManagerInterface $em, AutorRepository $autorRepository)
    {
        $this->em = $em;
        $this->postsRepository = $postsRepository;
        $this->autorRepository = $autorRepository;
    }

    #[Route('/lista', name: 'app_lista')]
    public function index(): Response
    {

    $posts = $this->postsRepository->findAll();
    
    //dd($posts);
        return $this->render('lista/index.html.twig', [
            'lista' => $posts
        ]);
    
    }

    #[Route('/lista/show/{id}', name: 'lista_show')]
    public function show($id): Response
    {
        $posts = $this->postsRepository->find($id);
        
        $name = $this->postsRepository->getValueAutor($id);

        return $this->render('lista/show.html.twig', [
            'lista' => $posts,
            'autor' => $name[0]['name']
        ]);
        
    }

    #[Route('/lista/delete/{id}', methods:['GET', 'DELETE'], name: 'lista_delete')]
    public function delete($id): Response
    {
        $posts = $this->postsRepository->find($id);

        $this->em->remove($posts);
        $this->em->flush();

        return $this->redirectToRoute('app_lista');

    }
        
}
