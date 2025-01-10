<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\PostRepository;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/company')]
final class CompanyController extends AbstractController
{
    #[Route(name: 'app_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/posts', name: 'app_company_posts', methods: ['GET'])]
    public function showPosts(Company $company, PostRepository $postRepository): Response
    {    
        $posts = $postRepository->findBy(['id' => $company->getId()]);

        //dd($posts);
        return $this->render('post/index3.html.twig', [
            'posts' => $posts,
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Company $company, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }
        $companyID = $user->getCompany()->getId();

        if ($companyID == $company->getId()) {
            $form = $this->createForm(CompanyType::class, $company);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //gestion de la photo de profil 
                $logoFile = $form->get('logo')->getData();

                if ($logoFile) {
                    $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$logoFile->guessExtension();

                    try {
                        $logoFile->move(
                            $this->getParameter('avatars_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Gérer l'erreur
                    }

                    $company->setLogo($newFilename);
                }
                $entityManager->flush();

                return $this->redirectToRoute('app_company_edit', ['id' => $companyID], Response::HTTP_SEE_OTHER);
            }

            return $this->render('company/edit.html.twig', [
                'company' => $company,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
        
    }

    #[Route('/{id}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($company);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
