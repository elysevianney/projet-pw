<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user) {
            if (!$user instanceof User) {
                throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
            }
            if(in_array('ROLE_DEV', $user->getRoles())){
                $devId = $user->getDev()->getID();
                return $this->render('welcome/index.html.twig', [
                    'devId' => $devId,
                ]);
            } elseif (in_array('ROLE_COMPANY', $user->getRoles())) {
                $companyId = $user->getCompany()->getID();
                return $this->render('welcome/index.html.twig', [
                    'companyId' => $companyId,
                ]);
            }
        }  else {
            return $this->render('welcome/index.html.twig');
        }
        
    }

    

}
