<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyCritere;
use App\Entity\Dev;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('statut')->getData() == 'ROLE_COMPANY') {
                $user->setRoles(['ROLE_COMPANY']);
            } elseif ($form->get('statut')->getData() == 'ROLE_DEV'){
                $user->setRoles(['ROLE_DEV']);
            }
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));


            if ($form->get('statut')->getData() == 'ROLE_COMPANY') {
                $user->setRoles(['ROLE_COMPANY']);
                $company = new Company();
                $company->setUser($user);
                
                $entityManager->persist($user);
                $entityManager->flush();

                $entityManager->persist($company);
                $entityManager->flush();

                $companyCritère = new CompanyCritere();
                $companyCritère->setCompany($company);
                $entityManager->persist($companyCritère);
                $entityManager->flush();

            } elseif ($form->get('statut')->getData() == 'ROLE_DEV'){
                $dev = new Dev();
                $dev->setUser($user);
                $user->setRoles(['ROLE_DEV']);

                $entityManager->persist($user);
                $entityManager->flush();
                
                $entityManager->persist($dev);
                $entityManager->flush();
            }

            

            // do anything else you need here, like send an email
            
            //return $security->login($user, UserAuthenticator::class, 'main');
            
            return $this->redirectToRoute('app_login');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
