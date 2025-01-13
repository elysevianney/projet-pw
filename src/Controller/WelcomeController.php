<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\DevRepository;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function index(DevRepository $devRepository, PostRepository $postRepository): Response
    {   
        // Récupérer les développeurs triés par count_view
        $bestDevs = $devRepository->findAllOrderByCountViewDsc();
        $lastThreeDevs = $devRepository->findLastThreeDevs();

        // Récupérer les posts triés par viewCount
        $bestPosts = $postRepository->findAllOrderByViewCountDesc();
        $lastThreePosts = $postRepository->findLastThreePosts(3);

        
        
        $user = $this->getUser();
        if ($user) {
            if (!$user instanceof User) {
                throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
            }
            if(in_array('ROLE_DEV', $user->getRoles())){
                $devId = $user->getDev()->getID();
                return $this->render('welcome/index.html.twig', [
                    'devId' => $devId,
                    'lastThreePosts' => $lastThreePosts,
                    'bestPosts' => $bestPosts,
                ]);
            } elseif (in_array('ROLE_COMPANY', $user->getRoles())) {
                $companyId = $user->getCompany()->getID();
                return $this->render('welcome/index.html.twig', [
                    'companyId' => $companyId,
                    'bestDevs' => $bestDevs,
                    'lastThreeDevs' => $lastThreeDevs,
                ]);
            }
        }  else {
            return $this->render('welcome/index.html.twig', [
                'bestDevs' => $bestDevs,
                'lastThreeDevs' => $lastThreeDevs,
                'lastThreePosts' => $lastThreePosts,
                'bestPosts' => $bestPosts,
            ]);
        }
        
    }

    

}
