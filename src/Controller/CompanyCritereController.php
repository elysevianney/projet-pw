<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\CompanyCritere;
use App\Form\CompanyCritereType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompanyCritereRepository;
use App\Repository\DevRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/company/critere')]
final class CompanyCritereController extends AbstractController
{
    #[Route(name: 'app_company_critere_index', methods: ['GET'])]
    public function index(CompanyCritereRepository $companyCritereRepository): Response
    {
        return $this->render('company_critere/index.html.twig', [
            'company_criteres' => $companyCritereRepository->findAll(),
        ]);
    }

    #[Route('/index2',name: 'app_company_critere_index2', methods: ['GET'])]
    public function index2(CompanyCritereRepository $companyCritereRepository, DevRepository $devRepository): Response
    {


        
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        $companyID = $user->getCompany();

        $critere = $companyCritereRepository->findOneBy(['company'=> $companyID]);
        if (!$critere instanceof CompanyCritere) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }
        $devs = $devRepository->searchDevs(
            $critere->getMinimumSalary(),
            $critere->getMaximumSalary(),
            $critere->getCity(),
            $critere->getTechnos(),
            $critere->getExperience()
            
        );
        //dd($critere);

        //dd($devs);
        return $this->render('dev/index2.html.twig', [
            'devs' => $devs,
        ]);
    }

    #[Route('/new', name: 'app_company_critere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        $company = $user->getCompany();

        $companyCritere = new CompanyCritere();
        $form = $this->createForm(CompanyCritereType::class, $companyCritere);
        $form->handleRequest($request);
        $companyCritere->setCompany($company);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($companyCritere);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company_critere/new.html.twig', [
            'company_critere' => $companyCritere,
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_critere_show', methods: ['GET'])]
    public function show(CompanyCritere $companyCritere): Response
    {
        return $this->render('company_critere/show.html.twig', [
            'company_critere' => $companyCritere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_critere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompanyCritere $companyCritere, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        $company = $user->getCompany();

        $form = $this->createForm(CompanyCritereType::class, $companyCritere);
        $form->handleRequest($request);
        $companyCritere->setCompany($company);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_company_critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company_critere/edit.html.twig', [
            'company_critere' => $companyCritere,
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_critere_delete', methods: ['POST'])]
    public function delete(Request $request, CompanyCritere $companyCritere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$companyCritere->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($companyCritere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_company_critere_index', [], Response::HTTP_SEE_OTHER);
    }
}
