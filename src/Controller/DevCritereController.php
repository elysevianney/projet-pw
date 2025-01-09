<?php

namespace App\Controller;

use App\Entity\Dev;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\DevCritere;
use App\Form\DevCritereType;
use App\Repository\PostRepository;
use App\Repository\DevCritereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dev/critere')]
final class DevCritereController extends AbstractController
{
    #[Route(name: 'app_dev_critere_index', methods: ['GET'])]
    public function index(DevCritereRepository $devCritereRepository): Response
    {
        return $this->render('dev_critere/index.html.twig', [
            'dev_criteres' => $devCritereRepository->findAll(),
        ]);
    }

    #[Route('/index2',name: 'app_dev_critere_index2', methods: ['GET'])]
    public function index2(DevCritereRepository $devCritereRepository, PostRepository $postRepository): Response
    {


        
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        $dev = $user->getDev();

        $critere = $devCritereRepository->findOneBy(['dev'=> $dev]);

        if (!$critere instanceof DevCritere) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }
        $posts = $postRepository->searchPosts(
            $critere->getMinimumSalary(),
            $critere->getMaximumSalary(),
            $critere->getCity(),
            $critere->getTechnos(),
            $critere->getExperience()
            
        );
        //dd($critere);

        //dd($devs);
        return $this->render('post/index2.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/new', name: 'app_dev_critere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devCritere = new DevCritere();
        $form = $this->createForm(DevCritereType::class, $devCritere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($devCritere);
            $entityManager->flush();

            return $this->redirectToRoute('app_dev_critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dev_critere/new.html.twig', [
            'dev_critere' => $devCritere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dev_critere_show', methods: ['GET'])]
    public function show(DevCritere $devCritere): Response
    {
        return $this->render('dev_critere/show.html.twig', [
            'dev_critere' => $devCritere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dev_critere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DevCritere $devCritere, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas de type User.');
        }

        $dev = $user->getDev();
        $form = $this->createForm(DevCritereType::class, $devCritere);
        $form->handleRequest($request);
        $devCritere->setDev($dev);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dev_critere_index2', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dev_critere/edit.html.twig', [
            'dev_critere' => $devCritere,
            'form' => $form,
            'dev' => $dev,
        ]);
    }

    #[Route('/{id}', name: 'app_dev_critere_delete', methods: ['POST'])]
    public function delete(Request $request, DevCritere $devCritere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devCritere->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($devCritere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dev_critere_index', [], Response::HTTP_SEE_OTHER);
    }
}
