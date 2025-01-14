<?php

namespace App\Controller;

use App\Form\DevSearchType;
use App\Form\PostSearchType;
use App\Repository\DevRepository;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search/dev', name: 'app_dev_search')]
    public function devSearch(DevRepository $devRepository, Request $request): Response
    {
        $form = $this->createForm(DevSearchType::class);
        $form->handleRequest($request);

        $devs = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $filters = [
                'minimumSalay' => $form->get('minimumSalay')->getData(),
                'experience' => $form->get('experience')->getData(),
                'city' => $form->get('city')->getData(),
                'technos' => $form->get('technos')->getData(),
                
                'lastname' => $form->get('lastname')->getData(),
                'firstname' => $form->get('firstname')->getData(),
            ];
            $devs = $devRepository->findByFilters($filters);
        }

        return $this->render('dev/search.html.twig', [
            'form' => $form->createView(),
            'devs' => $devs,
        ]);
    }

    #[Route('/search/post', name: 'app_post_search')]
    public function postSearch(Request $request, PostRepository $postRepository): Response
    {
        //dd("cc");
        $form = $this->createForm(PostSearchType::class);
        $form->handleRequest($request);

        $posts = [];
        $allPosts =  $postRepository->findOneBy([], orderBy: ['id' => 'DESC']);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = [
                'salary' => $form->get('salary')->getData(),
                'name' => $form->get('name')->getData(),
                'experience' => $form->get('experience')->getData(),
                'city' => $form->get('city')->getData(),
                'technos' => $form->get('technos')->getData(),
            ];
            
            $posts = $postRepository->searchPosts($criteria);
        }
        //dd($posts);
        return $this->render('post/search.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts,
            'allPots' => $allPosts
        ]);
    }
}
