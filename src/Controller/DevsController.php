<?php

namespace App\Controller;

use App\Entity\Dev;
use App\Entity\User;
use App\Form\DevUpdateProfileType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevsController extends AbstractController
{
    /*
    #[Route('/dev', name: 'app_dev')]
    public function index(): Response
    {
        return $this->render('dev/index.html.twig', [
            'controller_name' => 'DevController',
        ]);
    }

    #[IsGranted('ROLE_DEV')]
    #[Route('/dev/update_profile', name: 'app_dev_edit_profil' )]
    public function updateProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
    
        
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }
 
        $dev = $user->getDev();
        // ...

        $form = $this->createForm(DevUpdateProfileType::class, $dev);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->persist($dev);
            $entityManager->flush();

            // Ajouter un message flash
            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            // Rediriger vers une autre page, par exemple la page de profil
            return $this->redirectToRoute('app_dev_edit_profil');
        }
        //dd("cc");
        return $this->render('dev/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/
}
